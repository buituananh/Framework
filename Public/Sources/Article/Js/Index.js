var ListArticleSummaryObj = new ListArticleSummary();
ListArticleSummaryObj.RegisterEvent();
var MenuObj = new Menu();
MenuObj.RegisterEvent();

function ListArticleSummary()
{
    var This = this;
    
    this.RegisterEvent = function()
    {
        $('.ArticleTitleChose').click(function(){This.ShowArticle(this);});
    };
    
    this.ShowArticle = function(e)
    {        
        var ArticleContainer = $(e).parent();
        var ArticleContent = $(ArticleContainer).children('.ArticleContentChose');  
        var ArticleWraper = $(ArticleContent).parent();
        var ArticleList = $(ArticleWraper).parent();
        var Articles = $(ArticleList).children('.ArticleSummaryContainer');
        for(var Pos = 0; Pos < Articles.length; Pos++)
        {
            var ArticleContentChild = $(Articles[Pos]).children('.ArticleContentChose');
            $(ArticleContentChild).hide();
        }
        $(ArticleContent).show();
        $(ArticleContent).show();
    };
}

function Menu()
{
    var This = this;
    this.UriControl_Map = '/Article/Map/BasicControl';
    this.Uri_WriteArticle = '/Article/Editor';
    this.Uri_YourArticle = '/Article/Editor';
    this.Uri_Follow = '/Article/Follow/Basic';
    this.UriControl_Manual = '/Article/Manual/BasicControl';    
    this.Uri_Home = '/';
    this.DynamicContent = '#DynamicContent';
    
    this.RegisterEvent = function()
    {
        $('.SupportAction').click(function(){This.ExecuteAction(this);});
    };
    
    this.ExecuteAction = function(e)
    {
        switch (e.id)
        {
            case 'Map':
                $(This.DynamicContent).load(This.UriControl_Map);
                This.ShowDynamicContent();
                break;
            case 'Write':
                window.open(This.Uri_WriteArticle);
                break;
            case 'YourArticle':
                window.open(This.Uri_YourArticle);
                break;
            case 'YourFollow':
                window.open(This.Uri_Follow);
                break;
            case 'Manual':
                $(This.DynamicContent).load(This.UriControl_Manual);
                This.ShowDynamicContent();                
                break;
            case 'Center':
                This.HideDynamicContent();
                break;
            case 'Home':
                window.location.replace(This.Uri_Home);
                break;            
            default :
                return;
        }
    };
    
    this.ShowDynamicContent = function()
    {
        $('#CenterContent').hide();
        $('#DynamicContent').show();
    };
    
    this.HideDynamicContent = function()
    {
        $('#DynamicContent').hide();
        $('#CenterContent').show();
    };    
}