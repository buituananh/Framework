var WraperMgrObj = new WraperMgr('SummaryContainer');
WraperMgrObj.RegistryEvent();



function WraperMgr(WraperClass)
{
    var This = this;
    this.WraperClass = WraperClass;
    
    this.RegistryEvent = function()
    { 
        $('.'+WraperClass.replace(/\./g, '\\.')).click(function(){This.ClickSummary(this);});
    };
    this.ClickSummary = function(SummaryContainer)
    {  
        /*Read display of expand of wraper*/
        var Wraper = $(SummaryContainer).parent(); 
        var ExpandContainer = Wraper.children('.ExpandContainer');
        var Display = ExpandContainer.attr('display');
        /**/
        
        /**/
        if (Display === 'none' || Display === undefined)
        {
            This.ShowExpand(ExpandContainer); 
        }
        else
        {
            This.HideExpand(ExpandContainer);
        }        
    }; 
    this.ShowExpand = function(ExpandContainer)
    {
        $(ExpandContainer).slideDown(100); 
        $(ExpandContainer).attr('display', 'block');
    };
    this.HideExpand = function(ExpandContainer)
    {
        $(ExpandContainer).slideUp(100); 
        $(ExpandContainer).attr('display', 'none');
    };
}