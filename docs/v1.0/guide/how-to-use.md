# How To Use

## Displaying Markdown

### Facades

You may use the facade to pass markdown and return the equivalent html. The Markdown facade has only one method `writedown('markdown here')`.

#### Plain PHP

```php
$html = Writedown::content('# title')->toHtml();
```

#### Blade Views

You will need to use the unescaped echo because the converter returns html.

```php
{!! Writedown::content('# title')->toHtml() !!}
```

### Blade Intergration

If the `tags` configuration is set to `true`.  You may use the following "curly" brace short-cut in your `*.blade.php` files.

```php
{% '# title' %}
```

#### Echoing Markdown If It Exists

Like Blade's escaped echo `{% raw %}{{{% endraw %}` `{% raw %}}}{% endraw %}` the markdown tags are also equipped with the short-cut ternary statement.  If the pass variable that doesn't exists the markdown will only parse the default.

```php
{% $variable or 'default' %}
```

#### Ignoring Tags For JavaScript

If you are using a JavaScript template engine which uses the markdown "curly" braces, just like Blade's existing "curly" braces, you may add a leading `@` to leave it untouched.

```php
@{% javascript stuff %}
```

## Views Extensions

If the `views` configuration is set to `true` you may use views with the following extensions: `*.md`, `*.md.php`, and `*.md.blade.php`.  The `*.md` views will parse the markdown and return the html equivalent, while the `*.md.php`, and `*.md.blade.php` will parse the php first followed by the markdown last.

### Markdown

Matching files ending with `*.md`.

```markdown
# title
## subtitle

text
```

### Markdown PHP

Matching files ending with `*.md.php`.

```php
# <?php echo 'title' ?>
<?php echo '## subtitle' ?>

text
```

### Markdown Blade

Matching files ending with `*.md.blade.php`.

```php
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

::: warning
Some Markdown parsers may or may not require blank line between the different elements. Please check the parser's documentation for the right formatting.
:::
