STR_VALID_FORMAT = 0; 
STR_EMPTY = 1; 
STR_INVALID_LENGTH = 2; 
STR_INVALID_CHAR = 3; 
STR_INVALID_FORMAT = 4;
ACTIVE_LOGIN = 1;
ACTIVE_REGISTRY = 2;
ACTIVE_FORGOT_PASSWORD = 2;
ACTIVE_CHANGE_PASSWORD = 2;

UriJson_GetLoginStatus = '/User/State/Json_Check';
UriJson_GetPublicKey = '/Security/Json_GetPublicKey';
UriJson_Login = '/User/Login/Json_ByUserName';
UriJson_GetLinkAvatar = '/User/Info/Json_GetAvatarLinkByUserName';
UriJson_Logout = '/User/Logout/Json_Basic';
//===========================================================
//Need more time to develop real time linking
//This command bellow is disable until I develop complete
//var Linker = new Linker();
//===========================================================
var Active = ACTIVE_LOGIN;
var Processing = new Processing("ProcessingContainer", "Processing"); 
var Avatar = new Avatar("AvatarContainer", "Avatar");
var CaptchaImg = new CaptchaImg("CaptchaImgContainer", "/Protector/User/Authentication/GenarateCaptcha");
var Menu = new Menu();
var InputManager = new InputManager();
var UserInfo = new UserInfo();

/*Event handle*/
$("#LoginUi").click(function () {
    Active = ACTIVE_LOGIN;
    Menu.Login();
    InputManager.Login();
});
$("#RegistryUi").click(function () {
    Active = ACTIVE_REGISTRY;
    Menu.Registry();
    InputManager.Registry();
    if (!CaptchaImg.Used) CaptchaImg.CreateNew();
    CaptchaImg.Show();
});
$("#ForgotPassword").click(function () {
    InputManager.ForgotPassword();
    Menu.ForgotPassword();
});
$('#User').keypress(function (e) {
    if (((Active === ACTIVE_LOGIN)) && (e.which === 13)) {
        Login();
    }
    if (((Active === ACTIVE_REGISTRY)) && (e.which === 13)) {
        Registry();
    }
    if (((Active === ACTIVE_FORGOT_PASSWORD)) && (e.which === 13)) {
        GetPassword();
    }
});
$('#Password').keypress(function (e) {
    if (((Active === ACTIVE_LOGIN)) && (e.which === 13)) {
        Login();
    }
    if (((Active === ACTIVE_REGISTRY)) && (e.which === 13)) {
        Registry();
    }
});
$('#Email').keypress(function (e) {
    if (((Active === ACTIVE_REGISTRY)) && (e.which === 13)) {
        Registry();
    }
});
$('#Captcha').keypress(function (e) {
    if (((Active === ACTIVE_REGISTRY)) && (e.which === 13)) {
        Registry();
    }
    if (((Active === ACTIVE_FORGOT_PASSWORD)) && (e.which === 13)) {
        GetPassword();
    }
});
$("#Login").click(function () {
    Login();
});
$("#Registry").click(function () {
    Registry();
});
$(document).keyup(function (e) {
    if (e.which === 27) Logout();
});
$("#Logout").click(function () {
    Logout();
});
$("#CaptchaImg").click(function () {
    CaptchaImg.CreateNew();
});
$("#GetPassword").click(function () {
    GetPassword();
});
$("#Home").click(function () {
    window.location.replace("/");
});
$("#Setting").click(function () {
    window.location.replace("/Account/Personal");
});

function RsaEncrypt(Str) {
    $.post
    (
        UriJson_GetPublicKey,
        {

        },
        function (data) {
            var Respond;
            try {
                var Respond = data;
            }
            catch (e) {
                SetCookie('Encrypted', 0);
                return;
            }
            if (Respond.Result === undefined || !Respond.Result) return;
            var PublicKey = RSA.getPublicKey(Respond.PublicKey);
            SetCookie('Encrypted', RSA.encrypt(Str, PublicKey));
        }
    );
    var Encrypted = GetCookie('Encrypted');
    DeleteCookie('Encrypted');
    return Encrypted;
}
function Background() {
    $.post
    (
        UriJson_GetLoginStatus,
        {

        },
        function (Respond) 
        {
            if (Respond.Result === undefined || !Respond.Result || !Respond.Logging)
            {
                Avatar.SetShield();
                InputManager.Login();
                Menu.Login();
            }
            else {
                UserInfo.SetUserName(Respond.User.UserName);
                UserInfo.Show();
                Avatar.SetUser(Respond.User.UserName);
                Menu.Logging();
                InputManager.Logging();
            }
        }
    );
}

function UserInfo()    
{
    this.SetUserName = function(UserName)
    {
        $("#UserName").text(UserName);               
    };    
    this.Show = function()
    {
        $("#UserNameContainer").slideDown();
    };
}
function InputManager()
{
    this.Login = function()
    {
        CaptchaImg.Hide();
        $("#EmailContainer").slideUp();  
        $("#CaptchaContainer").slideUp();
        $("#UserContainer").slideDown();
        $("#PasswordContainer").slideDown();         
        $("#ForgotPassword").show();        
    };
    this.Registry = function()
    {
        $("#UserContainer").slideDown();
        $("#PasswordContainer").slideDown();
        $("#EmailContainer").slideDown(); 
        $("#CaptchaContainer").slideDown();
        CaptchaImg.Show();       
    };     
    this.Logging = function()
    {
        $("#UserContainer").slideUp();
        $("#PasswordContainer").slideUp();
        $("#EmailContainer").slideUp();   
        CaptchaImg.Hide();          
    };
    this.ForgotPassword = function()
    {
        CaptchaImg.CreateNew();
        CaptchaImg.Show();
        $("#EmailContainer").slideDown();    
        $("#UserContainer").slideDown();               
        $("#EmailContainer").slideUp();
        $("#PasswordContainer").slideUp();
         $("#CaptchaContainer").slideDown();
    };
}
function Menu()
{
    this.Login = function()
    {
        $("#LoginUi").hide();
        $("#Login").show();
        $("#RegistryUi").show();
        $("#Registry").hide();        
        $("#GetPassword").hide(); 
    };
    this.Registry = function()
    {
        $("#ForgotPassword").hide();
        $("#Logout").hide();  
        $("#LoginUi").show();
        $("#Login").hide();
        $("#RegistryUi").hide();
        $("#Registry").show();         
    };    
    this.Logging = function()
    {
        $("#ForgotPassword").hide();
        $("#LoginUi").hide();
        $("#Registry").hide();
        $("#Login").hide();
        $("#RegistryUi").hide();
        $("#Logout").show();  
        $("#Setting").show();  
    };
    this.ForgotPassword = function()
    {
        $("#ForgotPassword").hide();        
        $("#Registry").hide();
        $("#Login").hide();
        $("#RegistryUi").hide();
        $("#Logout").hide();  
        $("#Setting").hide();    
        $("#GetPassword").show();   
        $("#LoginUi").show();
    };
}
function Processing(Container, Cmd)
{
    this.Container = Container;
    this.Cmd = Cmd;
    this.Show = function()
    {
        $("#"+this.Container).slideDown();
    };
    this.Hide = function()
    {
        $("#"+this.Container).slideUp();
    };    
    this.Msg = function(Str)
    { 
        $("#"+this.Cmd).append("<li>"+Str+"</li>");
    };
    this.MsgException = function(Str)
    {
        $("#"+this.Cmd).append("<li class='Error'>"+Str+"</li>");
    };
    this.MsgSuccess = function(Str)
    {
        $("#"+this.Cmd).append("<li class='Success'>"+Str+"</li>");
    };    
    this.Clear = function()
    {
        $("#"+this.Cmd).empty();
    };
}
function Avatar(Container, Avatar)
{   
    this.Container = Container;
    this.Avatar = Avatar;    
    this.Set = function(Url)
    {
        $("#"+Avatar).attr({"src" : Url});   
    };
    this.SetShield = function()
    {
        $("#"+Avatar).attr({"src" : "/Framework/Icon/Standard/Shield.png"});   
    };     
    this.SetDef = function()
    {
        $("#"+Avatar).attr({"src" : "/Framework/Icon/Standard/User.png"});   
    };  
    this.SetWaiting = function()
    {
        $("#"+Avatar).attr({"src" : "/Framework/Gif/Waiting002.gif"});   
    };   
    this.SetUser = function (UserName)
    {
        $.post
        (                        
            UriJson_GetLinkAvatar,
            {
                UserName: UserName
            },
            function (Respond)
            {     
                if (Respond.Result === undefined || !Respond.Result) return;
                $("#"+Avatar).attr({"src" : Respond.Path+"?time="+Date()});   
                $("#"+Avatar).fadeIn();
            }
        );         
    };
}
function CaptchaImg(Container, Src)
{
    this.Container = Container;
    this.Src = Src;
    this.Id = "CaptchaImg";
    this.Used = false;
    this.CreateNew = function()
    {
        this.Used = true;
        $("#"+this.Id).attr({"src": this.Src+'?time='+Date()});
    };
    this.Show = function()
    {
        $("#"+this.Container).show();
    };
    this.Hide = function()
    {
        $("#"+this.Container).hide();
    };    
}
function Login()
{
    /*Ui*/
    Avatar.SetWaiting();
    Processing.Clear();
    Processing.Show();
    /*Valid user name*/
    Processing.Msg("Check user");    
    var UserName = $("#User").val();
    if (!CheckUserCmd(UserName)) {HandleException(); return false;}
    Processing.Msg("Check password");
    /*Valid password*/
    var Password = $("#Password").val();
    if (!CheckPasswordCmd(Password)) { HandleException(); return false; }
    /*Get public key from server*/
    Processing.Msg("Invoke login to server");      
    $.post
    (
        UriJson_GetPublicKey,
        {
            
        },
        function (data)
        {             
            Processing.Msg("Server respond invoke");
            try 
            {
                var Respond = data;
            }
            catch(e)
            {
                Processing.MsgException("Server: some exception");    
                HandleException(); 
                return;
            }
            /*Check respond*/
            //if (Respond.Result === undefined || !Respond.Result) 
            //{
            //    Processing.MsgException("Result: fail");    
            //    HandleException(); 
            //    return;                
            //} 
            //if (Respond.KeyHash === undefined || Respond.KeyHash === '') 
            //{
            //    Processing.MsgException("Key hash: invalid");    
            //    HandleException(); 
            //    return;                
            //}             
            /**/
            //Processing.Msg("Encrypt authentication");             
            var PassHash2 = Password;//Sha256(Sha256(Password) + Respond.KeyHash);  
            Processing.Msg("Sent authenticaion to server");  

            /*Invoke Login to server*/
            $.post
            (   
                UriJson_Login,
                {
                    UserName: UserName,
                    Password: PassHash2
                },
                function(Respond)
                {   
                    Processing.Msg("Server respond result");                    
                    if (Respond.Result === undefined || !Respond.Result)
                    {
                        Processing.MsgException("Server execute fail");
                        HandleException(); 
                        return 0;
                    }
                    if (Respond.Logged === undefined || !Respond.Logged) {
                        Processing.MsgException("Authentication fail: wrong user or password");
                        HandleException();
                        return 0;
                    }
                    Processing.MsgSuccess("Login success");                    
                    $("#UserContainer").slideUp();
                    $("#PasswordContainer").slideUp();                    
                    $("#PasswordContainer").val("");     
                    $("#Login").hide();
                    $("#ForgotPassword").hide();
                    $("#Logout").show();
                    $("#RegistryUi").hide();
                    $("#Setting").show();
                    UserInfo.SetUserName(UserName);
                    UserInfo.Show();
                    Avatar.SetUser(UserName);
                    //===========================================================
                    //Need more time to develop real time linking
                    //This command bellow is disable until I develop complete
                    //Linker.Enable();
                    //===========================================================                    
                }
            );             
        }
    ); 
    function HandleException()
    { 
        Avatar.SetShield();
        Processing.MsgException("Login fail");
    };
}
function Logout()
{
    Processing.Clear();
    Processing.Show();
    Processing.Msg("Invoke logout");
    /*Invoke logout*/
    $.post
    (
        UriJson_Logout,
        {

        },
        function (Respond)
        { 
            if (Respond.Result === undefined || !Respond.Result || !Respond.Offline)
            {
                Processing.MsgException("Logout fail");                        
                return;
            }                    
            Processing.MsgSuccess("Logout success");
            Avatar.SetShield();                    
            $("#Login").show();                    
            $("#UserNameContainer").slideUp();
            $("#UserContainer").slideDown();
            $("#PasswordContainer").slideDown();                    
            $("#Logout").hide();                    
            $("#ForgotPassword").show();        
            $("#Setting").hide(); 
            $("#RegistryUi").show();    
        }


    );  
    function HandleException()
    {
        Avatar.SetShield();
        Processing.MsgException("Logout fail");
    };        
}
function Registry()
{
    /*Uri*/
    var UriJson_AddUser = '/Account/Json_AddUser';
    /*Ui*/
    Avatar.SetWaiting();
    Processing.Clear();
    Processing.Show(); 
    Processing.Msg("Check user");
    /*Valid User name*/
    var UserName = $("#User").val();
    if (!CheckUserCmd(UserName)) { HandleException(); return false; }
    /*Valid Password*/
    Processing.Msg("Check password");    
    var Password = $("#Password").val();    
    if (!CheckPasswordCmd(Password)) { HandleException(); return false; }
    /*Valid email*/
    Processing.Msg("Check email");
    var Email = $("#Email").val();
    if (!CheckEmailCmd(Email)) { HandleException(); return false; }
    /*Valid captcha*/
    Processing.Msg("Check captcha");   
    var Captcha = $("#Captcha").val();
    //if (!CheckCaptchaCmd(Captcha)) { HandleException(); return false; }
    /*Encrypt Password*/
    Processing.Msg('Encrypt data'); 
    var PasswordEncrypted = Password;//RsaEncrypt(Password);
    if (PasswordEncrypted === '0')
    {
        Processing.MsgException('Encrypt data: fail');
        HandleException();
        return 0;
    }
    /*Invoke create accont to server*/
    Processing.Msg("Sent data to server");  
    $.post
    (                            
        UriJson_AddUser,
        {
            UserName: UserName,
            PasswordEncrypted: PasswordEncrypted,
            Email: Email,
            Captcha: Captcha
        },
        function(data)
        {       
            Avatar.SetShield();
            Processing.Msg("Server respond result");
            var Respond;
            try 
            {
                var Respond = data;
            }
            catch(e)
            {
                Processing.MsgException("Server: some exception");   
                HandleException(); 
                return;
            }             
            if (Respond.Result === undefined || !Respond.Result)
            {
                for (Exception in Respond)
                {
                    if (Exception !== "Result") Processing.MsgException(Exception+": "+Respond[Exception]);         
                }      
                HandleException();
                return false;
            }       
            Processing.MsgSuccess("Registry success"); 
            CaptchaImg.CreateNew();
        }
    );     
    function HandleException()
    {
        Avatar.SetShield();
        Processing.MsgException("Registry fail");
    };        
}
function GetPassword()
{
    Processing.Clear();
    Processing.Show();
    Processing.Msg('Check user');
    var User = $("#User").val();
    if (!CheckUserCmd(User)) {HandleException(); return false;}
    Processing.Msg('Check captcha');
    var Captcha = $("#Captcha").val();
    if (!CheckCaptchaCmd(Captcha)) {HandleException(); return false;} 	
    Processing.Msg('Invoke get password to server');
    $.post
    (                
        "/Account/Active/GetPassword",
        {
            User: User,
            Captcha: Captcha
        },
        function(data)
        {  
            Processing.Msg('Server respond');
            try 
            {
                var Respond = eval ("(" + data + ")");
            }
            catch(e)
            {
                Processing.MsgException("Server: some exception");   
                return;
            }  
            if (!Respond.Result)
            {
                Processing.MsgException('You can not get password');
                this.HandleError();
            }
            Processing.Msg('Password sent to your email. Check it');
            Processing.Msg('Get password success');
        }        
    );
    this.HandleException = function()
    {
        Processing.MsgException('Get password fail');
    };
}
function CheckUserFormat(User)
{
    if (User === "") return STR_EMPTY;
    if (User.match(/^[a-zA-Z0-9]+$/) === null) return STR_INVALID_CHAR;
    if ((User.length < 6) || (User.length > 16)) return STR_INVALID_LENGTH;     
    return STR_VALID_FORMAT;
}
function CheckPasswordFormat(User)
{
    if (User === "") return STR_EMPTY;
    if (User.match(/^[a-zA-Z0-9]+$/) === null) return STR_INVALID_CHAR;
    if ((User.length < 6) || (User.length > 16)) return STR_INVALID_LENGTH;            
    return STR_VALID_FORMAT;
}
function CheckEmailFormat(Email)
{
    if (Email === "") return STR_EMPTY;
    if (Email.match(/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i) === null) return STR_INVALID_FORMAT;
    return STR_VALID_FORMAT;
}
function CheckCaptchaFormat(Captcha)
{
    if (Captcha === "") return STR_EMPTY;
    if ((Captcha.length < 6) || (Captcha.length > 8)) return STR_INVALID_LENGTH;
    if (Captcha.match(/^[a-zA-Z0-9]+$/) === null) return STR_INVALID_CHAR;
    return STR_VALID_FORMAT;
}
function CheckUserCmd(User)
{
    switch (CheckUserFormat(User))
    {
        case STR_EMPTY:{
            Avatar.SetShield();
            Processing.MsgException("Empty user"); 
            return false;                
        }
        case STR_INVALID_CHAR:{
            Avatar.SetShield();
            Processing.MsgException("User invalid: Allow a-Z, 0-9");           
            return false;             
        }          
        case STR_INVALID_LENGTH:{
            Avatar.SetShield();
            Processing.MsgException("User invalid: lenght ∈ [6, 16]");          
            return false;                
        }  
    }  
    return true;
}
function CheckPasswordCmd(Password)
{
    switch (CheckPasswordFormat(Password))
    {
        case STR_EMPTY:{
            Avatar.SetShield();
            Processing.MsgException("Empty password");           
            return false;               
        }
        case STR_INVALID_CHAR:{
            Avatar.SetShield();
            Processing.MsgException("Password invalid: Allow a-Z, 0-9");               
            return false;          
        }          
        case STR_INVALID_LENGTH:{
            Avatar.SetShield();
            Processing.MsgException("Password invalid: lenght ∈ [6, 16]");               
            return false;              
        }  
    }    
    return true;
}
function CheckEmailCmd(Email)
{
    if (Email !== "")
    switch (CheckEmailFormat(Email))
    {         
        case STR_INVALID_FORMAT:{
            Avatar.SetShield();
            Processing.MsgException("Email invalid: format as yourname@gmail.com");               
            return false;              
        }  
    }    
    return true;
}
function CheckCaptchaCmd(Captcha)
{
    switch (CheckCaptchaFormat(Captcha))
    {   
        case STR_EMPTY:{
            Avatar.SetShield();
            Processing.MsgException("Captcha not fill");               
            return false;              
        }        
        case STR_INVALID_LENGTH:{
            Avatar.SetShield();
            Processing.MsgException("Captcha invalid: lenght ∈ [6, 8]");               
            return false;              
        }        
        case STR_INVALID_CHAR:{
            Avatar.SetShield();
            Processing.MsgException("Captcha invalid: allow a-Z, 0-9");               
            return false;              
        }  
    }    
    return true;  
}
/*Background running*/
Background();