# Console client

You can use client.php script by calling:

```bash
./php client.php <url> <startDateTime> <endDateTime> <places>  
```

For example:

```bash
./php client.php http://www.mocky.io/v2/58ff37f2110000070cf5ff16 2017-12-09T09:00 2017-12-19T19:00 37
```


./php is a script for running the script using the dockerized PHP install.

# Output

In case of success, here is a sample for the output format:

```json
[
    {
        "product_id": 1,
        "available_starttimes": [
            "2017-11-20T09:30",
            "2017-11-20T09:30"
        ]  
    },
    {
        "product_id": 3,
        "available_starttimes": [
            "2017-11-20T09:30"
        ]
    }
]
```

In case of no product found:
```json
[]
```

In case of errors:
```json
[
    { 
        "error": " the exception message " 
    }
]
```
