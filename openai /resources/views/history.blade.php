<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Insight</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Insights history</h1>
        <div>
            @foreach ($insights as $insight)
                <li><p>{{$insight['content']}}</p> <span>{{$insight['input_data']}}</span></li>
            @endforeach
        </div>
    </div>
</body>
</html>

