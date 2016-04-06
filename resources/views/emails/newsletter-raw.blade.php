{{ strip_tags(preg_replace('#<br\s*/?>#i', "\n", $content)) }}

Leiratkozás: {{ $subscriber->getCancellationLink() }}