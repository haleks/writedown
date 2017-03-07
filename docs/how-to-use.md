# How To Use

- [Facades](#facades)
  - [Plain PHP](#plain-php)
  - [Blade Views](#blade-views)
- [Displaying Markdown](#displaying-markdown)
  - [Echoing Markdown If It Exists](#echoing-markdown-if-it-exists)
  - [Ignoring Tags For JavaScript](#ignoring-tags-for-javascript)
- [Views Extensions](#views-extensions)
  - [Mardown](#mardown)
  - [Mardown PHP](#mardown-php)
  - [Mardown Blade](#mardown-blade)

## Facades

You may use the facade to pass markdown and return the equivalent html.  The Markdown facade has only one method `writedown('markdown here')`.

### Plain PHP

```php
$html = Writedown::content('# title')->toHtml();
```

### Blade Views

You will need to use the unescaped echo because the converter returns html.

```php
{!! Writedown::content('# title')->toHtml() !!}
```

## Displaying Markdown

If the `tags` configuration is set to `true`.  You may use the following "curly" brace short-cut in your `*.blade.php` files.

```php
{% '# title' %}
```

### Echoing Markdown If It Exists

Like Blade's escaped echo `{{` `}}` the markdown tags are also equipped with the short-cut ternary statement.  If the pass variable that doesn't exists the markdown will only parse the default.

```php
{% $variable or 'default' %}
```

### Ignoring Tags For JavaScript

If you are using a JavaScript template engine which uses the markdown "curly" braces, just like Blade's existing "curly" braces, you may add a leading `@` to leave it untouched.

```php
@{% javascript stuff %}
```

## Views Extensions

If the `views` configuration is set to `true` you may use views with the following extensions: `*.md`, `*.md.php`, and `*.md.blade.php`.  The `*.md` views will parse the markdown and return the html equivalent, while the `*.md.php`, and `*.md.blade.php` will parse the php first and followed by the markdown.

### Mardown

```php
// *.md
# title
## subtitle

text
```

### Mardown PHP

```php
// *.md.php
# <?php echo 'title' ?>
<?php echo '## subtitle' ?>

text
```

### Mardown Blade

```php
// *.md.blade.php
# {{ 'title' }}
{{ '## subtitle' }}

text
```

All the example above will output:

```html
<h1>title</h1>
<h2>subtitle</h2>
<p>text</p>
```
