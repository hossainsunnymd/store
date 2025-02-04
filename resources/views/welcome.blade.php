<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


    <h1>Welcome</h1>

    <script>
        async function getData() {
            const res=await fetch('/brand-list');
            const data=await res.json();
            console.log(data);
        }

        getData();
    </script>
</body>
</html>
