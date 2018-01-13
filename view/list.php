<!DOCTYPE html>
<html>
<head>
    <include href="{{ @head_title }}" />
</head>
<body id="body">
<include href="{{ @nav }}" />
<check if="{{ isset(@errors) }}">
    <include href="{{ @problems }}" />
</check>
<div class="container">
    <div class="row">
        

    </div>
</div>
</div>
<footer>
    <include href="{{ @footer }}" />
</footer>
</body>
</html>