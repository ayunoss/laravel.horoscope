<!DOCTYPE html>
<html>
    <head>
            <meta charset="utf-8">
            <title>Please select your birth date</title>
        </head>
    <body>
        <form method="post" action="{{route('getBD')}}">
    {{csrf_field()}}
                <p>
                    <label for="firstname">Your name: </label>
                    <input type="text" id="firstname" name="firstname"/>
                </p>
                <p>
                     <label for="date">Birth date: </label>
                     <input type="date" id="date" name="date"/>
                </p>
                <p>
                     <button type="submit">Ok</button>
                </p>
            </form>
    </body>
</html>
