<p align="center">
<a href="https://haleks.ca"><img src="https://cloud.githubusercontent.com/assets/8269937/23192289/97ecb68c-f870-11e6-9855-14ca24889b16.png" alt="Haleks"></a>
</p>

[![travis ci](https://img.shields.io/travis/haleks/writedown/master.svg?style=flat-square)](https://travis-ci.org/haleks/writedown)
[![latest release](https://img.shields.io/github/release/haleks/writedown.svg?style=flat-square)](https://github.com/haleks/writedown/releases)
[![code climate](https://img.shields.io/codeclimate/github/haleks/writedown.svg?style=flat-square)](https://codeclimate.com/github/haleks/writedown)
[![style ci](https://styleci.io/repos/71916980/shield?style=square)](https://styleci.io/repos/71916980)
[![license](https://img.shields.io/badge/license-MIT-FF4E00.svg?style=flat-square)](license)

> Writedown integrate popular markdown parsers inside the blade template engine by enabling markdown "curly" braces, directives and / or views.

## Documentation

- [Prerequisites](prerequisites.md#prerequisites)
  - [Specifications](prerequisites.md#specifications)
  - [Supported Markdown Parser](prerequisites.md#supported-markdown-parser)
- [Installation](installation.md#installation)
  - [Pulling a Markdown Parser](installation.md#pulling-a-markdown-parser)
  - [Pulling The Package](installation.md#pulling-the-package)
  - [Registering The Package](installation.md#registering-the-package)
- [Configuration](configuration.md#configuration)
  - [Publish The Configuration](#publish-the-configuration)
  - [Options](configuration.md#options)
    - [Default Writedown Parser](configuration.md#default-writedown-parser)
    - [Enable Markdown Extensions](configuration.md#enable-markdown-extensions)
    - [Enable Views Extensions](configuration.md#enable-views-extensions)
    - [Parsers Configuration](configuration.md#parsers-configuration)
- [How To Use](how-to-use.md#how-to-use)
  - [Facades](how-to-use.md#facades)
    - [Plain PHP](how-to-use.md#plain-php)
    - [Blade Views](how-to-use.md#blade-views)
  - [Displaying Markdown](how-to-use.md#displaying-markdown)
    - [Echoing Markdown If It Exists](how-to-use.md#echoing-markdown-if-it-exists)
    - [Ignoring Tags For JavaScript](how-to-use.md#ignoring-tags-for-javascript)
  - [Views Extensions](how-to-use.md#views-extensions)
    - [Mardown](how-to-use.md#mardown)
    - [Mardown PHP](how-to-use.md#mardown-php)
    - [Mardown Blade](how-to-use.md#mardown-blade)

## License

Writedown is licensed under [The MIT License (MIT)](../LICENSE).
