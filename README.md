# CreateBox
CreateBox is a specialized version of [Inputbox](https://www.mediawiki.org/wiki/Extension:InputBox) that focuses on page creation. InputBox was originally created by Erik Möller for the purpose of adding a Create an article box to Wikinews.

This extension is forked from [Mediawiki Extension:CreateBox](http://www.mediawiki.org/wiki/Extension:CreateBox)

## Requirements
MediaWiki 1.24.0 or higher

## Installation
1. Command
 ```bash
    git clone https://github.com/wiki-chan/CreateBox.git
```
 in `$IP/extensions`

2. Enable the extension by adding this line to your LocalSettings.php:
 ```php
    wfLoadExtension( "CreateBox" ); 
```
