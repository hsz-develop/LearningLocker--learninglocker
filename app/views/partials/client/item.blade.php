<?php
	$authorityIdentifier;
	$authorityHTML;

	if (array_key_exists('mbox', $client->authority)){
		$authorityIdentifier = Lang::get('lrs.client.authority.mbox');
		$authorityHTML = substr($client->authority['mbox'],7);
		
	} else if (array_key_exists('mbox_sha1sum', $client->authority)){
		$authorityIdentifier = Lang::get('lrs.client.authority.mbox_sha1sum');
		$authorityHTML = $client->authority['mbox_sha1sum'];
		
	} else if(array_key_exists('openid', $client->authority)){
		$authorityIdentifier = Lang::get('lrs.client.authority.openid');
		$authorityHTML = $client->authority['openid'];
		
	} else if (array_key_exists('account', $client->authority)){
		$authorityIdentifier = Lang::get('lrs.client.authority.account');
		$authorityHTML = $client->authority['account']['homePage'].'/'.$client->authority['account']['name']
		;
			
	} else  {
		$authorityIdentifier = Lang::get('lrs.client.authority.ifi');
		$authorityHTML = '';
	}
	
?>
<a name="{{ $client->_id }}"></a>
<div class="panel panel-primary">
  <div class="panel-heading">
    	<h3 class="panel-title">
    		<div class="pull-left" >
    			{{ ($client->authority['name']) ? ($client->authority['name']) : Lang::get('lrs.client.unnamed_client') }}
    		</div>
    		&nbsp;
    		<div class="pull-right" style="margin-top: -6px;">
				<a href="{{ URL() }}/lrs/{{ $lrs->_id }}/client/{{ $client->_id }}/edit" class="btn btn-success btn-sm pull-right" title="{{ Lang::get('site.edit') }}">
					<i class="icon-pencil"></i><span class="hidden-xs"> {{ Lang::get('site.edit') }}</span>
				</a>
				@include('partials.client.forms.delete')
			</div>
    	</h3>
  </div>
  <div class="panel-body">
    <table class="table table-striped table-bordered table-xs-rows break-words">        
      <tr>
        <td>{{ $client->authority['name'] }}</td>
        <td>{{$authorityIdentifier}}: {{ $authorityHTML }}</td>
        <td>{{ $client->username }}</td>
        <td>{{ $client->password }}</td>
      </tr>
	  </table>
  </div>
</div>