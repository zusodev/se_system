package main

import (
    "net/http"
    "time"
)

func main() {
    const url = `http://target_url`
    const timeout = "3s"
    dur, _ := time.ParseDuration(timeout)
    (&http.Client{Timeout: dur}).Get(url)
}
