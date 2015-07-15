<?php namespace Lockr\Statement;
use App as IlluminateApp;
use Cache as IlluminateCache;
use Carbon\Carbon as Carbon;
use Locker\Helpers\Helpers as Helpers;
use Locker\Repository\Statement\Repository as XapiStatementsRepository;

class EloquentRepository implements Repository {
  public function __construct(XapiStatementsRepository $xapi_statements_repo) {
    $this->xapi_statements_repo = $xapi_statements_repo;
  }

  public function aggregate(array $pipeline, array $opts){
    if (strpos(json_encode($pipeline), '$out') !== false) {
      return;
    }
    $match = [
      'lrs._id' => $opts['client']->lrs_id,
      'active' => true
    ];

    $scopes = $opts['client']->scopes;
    if (in_array('all', $scopes) || in_array('all/read', $scopes) || in_array('statements/read', $scopes)) {
      // Get all statements.
    } else if (in_array('statements/read/mine', $scopes)) {
      $match['client_id'] = $opts['client']->_id;
    } else {
      throw new \Exception('Unauthorized request.');
    }

    $pipeline[0]['$match'] = [
      '$and' => [(object) $pipeline[0]['$match'], $match]
    ];

    $cache_key = sha1(json_encode($pipeline));
    $create_cache = function () use ($pipeline, $cache_key) {
      $expiration = Carbon::now()->addMinutes(10);
      $statements = IlluminateApp::make('db')->getMongoDB()->statements;
      $result = Helpers::replaceHtmlEntity($statements->aggregate($pipeline), true);
      IlluminateCache::put($cache_key, $result, $expiration);
      return $result;
    };

    //$result = IlluminateCache::get($cache_key, $create_cache);
    $result = $create_cache();

    return $result;
  }

  public function insert(array $pipeline, array $opts){
    $statements = $this->aggregate($pipeline, $opts)['result'];

    if (count($statements) > 0) {
      $opts['authority'] = json_decode(json_encode($opts['client']->authority));
      $opts['lrs_id'] = $opts['client']->lrs_id;
      $opts['scopes'] = $opts['client']->scopes;
      return $this->xapi_statements_repo->store(json_decode(json_encode($statements)), [], $opts);
    } else {
      return [];
    }
  }

  public function void(array $match, array $opts){
    $void_id = 'http://adlnet.gov/expapi/verbs/voided';

    $pipeline = [[
      '$match' => [
        '$and' => [(object) $match, [
          'statement.verb.id' => ['$ne' => $void_id],
          'voided' => false
        ]]
      ]
    ], [
      '$project' => [
        '_id' => 0,
        'actor' => ['$literal' => $opts['client']->authority],
        'verb' => [
          'id' => ['$literal' => $void_id],
          'display' => [
            'en' => ['$literal' => 'voided']
          ]
        ],
        'object' => [
          'objectType' => ['$literal' => 'StatementRef'],
          'id' => '$statement.id'
        ]
      ]
    ]];

    return $this->insert($pipeline, $opts);
  }

}
