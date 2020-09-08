function printDiv(divName) {
    $table = $('table,tr,td,th');
    $table.removeClass('table');
    $table.removeClass('table-responsive');
    $table.removeClass('table-bordered');
    $table.css({'border-collapse': 'collapse', 'border': '1px solid black'});
    $action=$('#action');
    $actionbutton=$('.actionbutton');
    $action.css('display','none');
    $actionbutton.css('display','none');

    var css = '@page { size: landscape; }',
        head = document.head || document.getElementsByTagName('head')[0],
        style = document.createElement('style');
    style.type = 'text/css';
    style.media = 'print';

    if (style.styleSheet) {
        style.styleSheet.cssText = css;
    } else {
        style.appendChild(document.createTextNode(css));
    }
    head.appendChild(style);
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}

function printPortraitDiv(divName) {
    var css = '@page { size: portrait; }',
        head = document.head || document.getElementsByTagName('head')[0],
        style = document.createElement('style');
    style.type = 'text/css';
    style.media = 'print';

    if (style.styleSheet) {
        style.styleSheet.cssText = css;
    } else {
        style.appendChild(document.createTextNode(css));
    }
    head.appendChild(style);
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}