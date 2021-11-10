# SE備註

### 備註事項

* 發信的時候，倘若目標對象為 gmail 用戶，其中的欄位 是否開啟(is_open) 有時候會被 Google Gmail 自動開啟，其為失效狀態。
* 附件的 log，必須使用 word 打開以及必須啟用編輯才會顯示 `範本失效`，顯示 `範本失效` 才會發出 Ajax 。

### 如何使用信件樣式(Email Template) 

在 信件樣式當中，樣式內容裡面有幾個關鍵字，會被替換成擷取 log 的 URL，關鍵字如下：
* `@name@`
* `@email@`
* `@password@`
* `@embedded_link@`

上傳的附件當中，也可使用關鍵字，以下為附件的關鍵字：

* `http://target_url`



## 當信件發失敗時，如何重發

信件發失敗主要可以依照 有沒有 EmailLog 來區分方法：

### 沒有 EmailLog

沒有 EmailLog 意味在 MailJobDispatchCommand 的 chunkByGroup 發信到一半時中斷，由於 MailJobDispatchCommand 為了避免 Race Condition，使用 status 等於 0(Wait Status) 作為判斷，所以必須用另一個物件 MailJobRedispatchCommand 來發信。

具體的用法必須使用 ssh 進入 Server，並下指令即可

```
$ php artisan mail:job:redispatch
``` 

### 有 EmailLog 但發信時失敗

通常這種狀態原因出於 SMTP Server 出現異常或大量發信阻塞，這種狀況由於 EmailLog 已經寫入 DB，可以透過 寄件 Log 的重新寄送來發信。
