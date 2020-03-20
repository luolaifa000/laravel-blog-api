cd /home/data/laravel-blog-api
echo 开始执行
git pull && docker stop blog_backend && docker rm blog_backend && docker build -t yumancang/blog_backend . && docker run -itd --name=blog_backend -p 81:81 -p 9000:9000 -p 6379:6379 yumancang/blog_backend /bin/sh
echo 执行完毕
