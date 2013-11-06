/*Create object*/
var ListArticleObj = new ListArticle();
var ArticleButtonObj = new ArticleButton();
var ArticleObj = new Article();
/*Register event*/
ListArticleObj.RegisterEvent();
ArticleButtonObj.RegisterEvent();
ArticleObj.RegisterEvent();
/*Run some method*/
ArticleButtonObj.OpenList();






function ArticleButton()
{
    var This = this;
    
    this.RegisterEvent = function()
    {
        $("#Article").click(function(){This.ShowOptionContainer();});        
        $(window).click(function(e) {This.HideOptionContainer(e);});        
        $(document).bind('keydown', function(e) {This.ShortcutKeyExecute(e);});        
        $("#Article\\.OpenList").click(function(){This.OpenList();});
        $("#Article\\.Exit").click(function(){This.Exit();});    
        $("#Article\\.New").click(function(){This.New();});               
        $("#Article\\.Save").click(function(){This.Save();});    
        $("#Article\\.Close").click(function(){This.Close();});    
        $("#Article\\.Edit").click(function(){This.Edit();});        
        $("#Article\\.Delete").click(function(){This.Delete();});             
    };
    
    this.ShortcutKeyExecute = function(e)
    {
        
        if (e.ctrlKey && e.which === 192)
        {
            This.Save();
        }  
        if(e.which === 192)
        {
            e.preventDefault();
            This.New();            
        }
    };
    
    this.HideOptionContainer = function(e)
    {
        if (e.target.id !== "Article")
        { 
            $(".OptionContainer").hide();        
        }        
    };
    this.ShowOptionContainer = function()
    {
        $("#OptionContainer").show();
    };
    this.New = function()
    {
        ArticleObj.NewArticle();
    };
    this.Save = function()
    {
        ArticleObj.SaveArticle();
    };
    this.Delete = function()
    {
        ArticleObj.Delete();
    };
    this.OpenList = function()
    {
       $(".ContentContainer").width("70%");
       if(!ListArticleObj.ListArticleLoaded)
       {
           ListArticleObj.LoadListArticle();
           ListArticleObj.ListArticleLoaded = true;
       }
       $("#ListArticleContainer").show();                
    };   
    this.Close = function()
    {
        $("#ContentHtml").text(""); 
        $("#ContentHtml").hide();    
        $("#Title").val("Framework article"); 
        $("#Title").attr('disabled','disabled');
        $("#Content").val("");   
        $("#Content").hide();   
        This.Status = this.STATUS_NEW;        
    };
    this.Edit = function()
    { 
        ArticleObj.EditArticle();
    };    
    this.Exit = function()
    {
        window.location.replace("/");
    };      
}

function ListArticle()
{
    var This = this;
    this.UriJson_LoadArticleCurrentUser = '/Article/Search/Json_CurrentUser';
    this.ListArticleLoaded = false;
    
    this.RegisterEvent = function()
    {
        
    };
    
    this.LoadListArticle = function()
    {
        $.post
        (
            This.UriJson_LoadArticleCurrentUser,
            {
                Page: 1,
                RowPerPage: 10
            },
            function(Respond)
            {
                if (!Respond.Exception)
                {
                    for (var Pos in Respond.Articles)
                    {
                        $("#ListArticle\\.TitleArticleContainer").append("<div class='TitleContainerList' id='Article."+Respond.Articles[Pos].Id+"'><div class='TitleArticle'>"+Respond.Articles[Pos].Name+"</div></div>");
                    }
                    $(".TitleContainerList").click(function()
                    {
                        var Id = this.id.split(".");
                        $(".TitleContainerList").css("background", "0");
                        $("#Article\\."+Id[1]).css("background", "#C9C9C9");
                        ArticleObj.Load(Id[1]);
                    });  
                    $(".TitleContainerList").mouseover(function()
                    {
                        $(this).css('background', '#C9C9C9');
                    });    
                    $(".TitleContainerList").mouseout(function()
                    {                        
                        if (this.id.split(".").pop() !== This.IdEditing) $(this).css('background', '#EBEBEB');
                    });                       
                }
                else
                {
                    
                }
            }
        );        
    };
    
}

function Article()
{
    var This = this;
    this.LoadId;
    this.UriJson_GetArticle = '/Article/Read/Json_ById';
    this.UriJson_UpdateArticle = '/Article/Update/Json_ById';
    this.UriJson_InsertArticle = '/Article/Insert/Json_Basic';
    this.UriJson_DeleteArticle = '/Article/Delete/Json_Basic';
    
    this.RegisterEvent = function()
    {
        
    };
    
    this.Load = function(Id)
    {
        This.LoadId = Id;  
        $("#Title").css("font-weight", "normal");
        $.post
        (
            This.UriJson_GetArticle,
            {
                Id: Id
            },
            function(Respond)
            {
                if (!Respond.Exception)
                {                    
                    $("#Title").val(Respond['Article'].Name);   
                    $("#Title").attr('disabled', true);
                    $("#Content").hide();                                       
                    $("#Content").val(Respond.Article.Contents);
                    $("#Content").show(); 
                    $("#Content").attr('readonly', true);                    
                    $("#Content").autosize(); 
                }
                else
                {
                    This.LoadId = 0;
                    alert(Respond.Article.Contents);
                }
            }
        );          
    };   
    
    this.NewArticle = function()
    {      
        $("#Title").attr('disabled', false);
        $("#Title").val("");                  
        $("#Content").val("");   
        $("#Content").attr('readonly', false);   
        $("#Content").show(); 
        $("#Content").select();
        This.LoadId = 0;
    };
    
    this.InsertArticle = function()
    {
        var Title =  $("#Title").val();
        var Content =  $("#Content").val();        
        $("#RespondWaiting").fadeIn(500);
        $.post
        (
           This.UriJson_InsertArticle,
           {
               Name: Title,
               Contents: Content
           },
           function(Respond)
           {
                $("#RespondWaiting").hide();
                if (!Respond.Exception)
                {
                    This.LoadId = Respond.Id; 
                    $("#ListArticle\\.TitleArticleContainer").empty();                    
                    $("#RespondOk").fadeIn(500).fadeOut(3000);
                    $("#Title").css("font-weight", "normal");
                }
                else
                {
                   $("#RespondError").fadeIn(500).fadeOut(3000);
                }            
           }
         );          
    };
    
    this.UpdateArticle = function()
    {
        var Title =  $("#Title").val();
        var Content =  $("#Content").val(); 
        $("#RespondWaiting").fadeIn(500);
        $.post
        (
           This.UriJson_UpdateArticle,
           {
               Id: This.LoadId,
               Name: Title,
               Contents: Content
           },
           function(Respond)
           { 
                $("#RespondWaiting").hide();
                if (!Respond.Exception)
                {
                   $("#ListArticle\\.TitleArticleContainer").empty();                   
                   $("#RespondOk").fadeIn(500).fadeOut(3000);     
                   $("#Title").css("font-weight", "normal");                        
                }
                else
                {
                    $("#RespondError").fadeIn(500).fadeOut(3000);
                }            
           }
         );         
    };

    this.Delete = function()
    {
        $.post
        (
            This.UriJson_DeleteArticle,
            {
                Id: This.LoadId
            },
            function(Respond)
            {
                if (Respond === undefined || Respond.Result === undefined || !Respond.Result)
                {
                    $("#RespondOk").fadeIn(500).fadeOut(3000);
                    $("#Content").val("");
                    $("#ContentHtml").empty();
                    $("#ContentHtml").hide();
                    $("#Content").hide();
                    $("#Title").val("Framework article");
                    $("#Title").attr('disabled','disabled');
                    $("#ListArticle\\.TitleArticleContainer").empty();
                    ListArticle().LoadListArticle();
                }
                else
                {
                    $("#RespondError").fadeIn(500).fadeOut(3000);
                }              
            }
        );          
    };
    this.SaveArticle = function()
    {
        /*Insert article*/
        if (This.LoadId === 0 || This.LoadId === undefined)
        {
            This.InsertArticle();
        }
        /*Update article*/
        else
        {
            This.UpdateArticle();
        } 
        ListArticleObj.LoadListArticle();
    };
    
    this.EditArticle = function()
    {
        $("#Title").attr('disabled', false);                                                          
        $("#Content").autosize();
        $("#Content").show();
        $("#Content").attr('readonly', false);
    };
}