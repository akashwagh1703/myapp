# myapp
This app is my machine test with Restfull API
***Features*** 
Build a full stack Master/User login & document module 
- Login would be via OTP 
- We don’t need to build a OTP engine, please use any free OTP APIs or google firebase APIs 
- Functionally is more important than fancy UI, we suggest you don’t spend time in making the UI beautiful 
- Backend developers who aren’t comfortable with frontend stack, can skip the frontend and work only on APIs and send across APIs (postman collection preferred) ● Below is the expected flow 

**Master Login** 
1. Show an option to accept mobile number 
2. On submit send OTP 
3. Show enter OTP screen, validate the OTP 
4. Admin will be able to login with Mobile Number and OTP 
5. Admin will be able to add users through a form 

**User Login** 
1. User will login using mobile number & OTP 
2. On successful login user will be asked to upload 1 document 
3. The document should be saved in the database 
4. All the uploaded document of that user should be visible in table format 

--------------------------------------------------------------------
***Run Myapp Project***  
- Download zip file and extract in Xampp/htdocs folder
- Create a new database in phpmyadmin with the name myapp.
- Import database from datatase folder of myapp
- Go to browser hit myapp
----------------------------------------------------------------------
***API Collection***
https://documenter.getpostman.com/view/21438439/UzBvFi9Y

