<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
            <link rel="stylesheet" href="/style.css">
    </head>
    <body>

        <div class="chat">

            <div class="top">
                <div>

                </div>
            </div>

            <div class="messages">
                <div class="left message">
                    <img src="/picture.jpg" alt="A Picture">
                    <p>Query me for Top Notch Articles</p>
                </div>
            </div>

            <div class="bottom">
                <form action="{{ route('create.Article') }}" method="POST">
                    @csrf()
                    @method('POST')
                    <input type="text" name="message" id="message" placeholder="Enter Topic...." autocomplete="off">
                    <select name="tone" id="tone">
                        <option selected value="NON">Select Article Content Tone</option>
                        <option  value="narrative">narrative</option>
                        <option value="authoritative">authoritative</option>
                        <option value="sad">sad</option>
                        <option value="emotional">emotional</option>
                        <option value="professional">professional</option>
                        <option value="happy">happy</option>
                        <option value="inspiring">inspiring</option>
                    </select>
                    <input type="number" name="density" id="density" placeholder="Enter Keyword Density Percentage">
                    <button type="submit"></button>
                </form>
            </div>

        </div>

    </body>
</html>
