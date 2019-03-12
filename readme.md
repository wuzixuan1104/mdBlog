# 歡迎來到 md To Html Prototype

此專案主要是要藉由 md 轉成 html，拿來當 Blog 的專案，專案採用 [Ginkgo](https://github.com/comdan66/Ginkgo) 的框架開發。

---

## 開發
* 修改 `cmd/libs/plugin/Cover.php`
* 設定要顯示的規則以及 Load view 的參數
* 修改 `views` 下的 view 檔案

## 編譯 html
* 假設本機端網址 `http://dev.myurl.tw/`
* 專案目錄下 `php cmd/libs/plugin/Cover.php --base-url http://dev.myurl.tw/`
* 開啟瀏覽器 `http://dev.myurl.tw/`

## 上傳
* 先執行 `git commit`
* 修改檔案 `cmd/_dirs.yaml` 設定要上傳的目錄
* `cmd` 目錄下執行指令 `node demo`
