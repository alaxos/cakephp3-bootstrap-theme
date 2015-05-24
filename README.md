# cakephp3-bootstrap-theme
Bootstrap bake templates for CakePHP 3

General Features
----------------
- Bootstrap templates that use the enhanced FormHelper and some other tools from the alaxos/cakephp3-libs plugin

Installation
------------

### Adding the plugin

You can easily install this plugin using composer as follows:

```bash
composer require alaxos/cakephp3-bootstrap-theme
```

### Enabling the plugin

After adding the plugin remember to load it in your `config/bootstrap.php` file.
The `Alaxos` plugin must be loaded as well.

```php
Plugin::load('Alaxos', ['bootstrap' => true]);
Plugin::load('Alaxos/BootstrapTheme');
```

### Using the plugin with bake

```bash
$ ./bin/cake bake model Users --theme Alaxos/BootstrapTheme
```


### Load Bootstrap CSS and JS

You may use the following functions to load Bootstrap CSS and JS in your template:

```php
<?php 
echo $this->AlaxosHtml->includeBootstrapCSS(['block' => false]);
echo $this->AlaxosHtml->includeBootstrapThemeCSS(['block' => false]);
echo $this->AlaxosHtml->includeAlaxosCSS(['block' => false]);
	
echo $this->AlaxosHtml->includeAlaxosJQuery(['block' => false]);
echo $this->AlaxosHtml->includeAlaxosBootstrapJS(['block' => false]);
?>
```
