<?php

return array(
	'^/$' => 'controller=site&action=index',
	'^/admin(?:/|)$' => 'module=admin&controller=site&action=index',
	'^/admin/([a-z0-9]{1,15})(?:/|)$' => 'module=admin&controller=$1&action=index',
	'^/admin/([a-z0-9]{1,15})/([0-9]{1,15})(?:/|)$' => 'module=admin&controller=$1&action=view&id=$2',
	'^/admin/([a-z0-9]{1,15})/([a-z0-9]{1,15})(?:/|)$' => 'module=admin&controller=$1&action=$2',
	'^/([a-z0-9]{1,15})(?:/|)$' => 'controller=$1&action=index',
	'^/([a-z0-9]{1,15})/([0-9]{1,15})(?:/|)$' => 'controller=$1&action=view&id=$2',
	'^/([a-z0-9]{1,15})/([a-z0-9]{1,15})(?:/|)$' => 'controller=$1&action=$2',
	'^/([a-z0-9]{1,15})/([a-z0-9]{1,15})/([0-9]{1,15})(?:/|)$' => 'controller=$1&action=$2&id=$3',
	'^(.*)$' => 'controller=site&action=error',
);