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
        <h1>Create a New Insight</h1>

        <!-- Display Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form to submit new insight -->
        <form action="{{ route('openai.store') }}" method="POST">
            @csrf  <!-- CSRF Protection -->
            <div class="mb-3">
                <label for="summarize_logs" class="form-label">Summarize Logs</label>
                <input type="text" class="form-control @error('summarize_logs') is-invalid @enderror" id="summarize_logs" name="summarize_logs" value="{{ old('summarize_logs') }}" required>
                @error('summarize_logs')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Input Data</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4" required>{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
