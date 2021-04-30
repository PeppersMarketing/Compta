function onClickBtnComm() {
    console.log("mon cul");
    // const  tr = $(this).parent();
    // const  section = tr.parent();
    // const  div = section.find('tr.blocCommHidden');
    //     var substring = 'd-none'
    //     if (div.attr('class').indexOf(substring) !== -1) {
    //         div.removeClass('d-none');
    //     } else {
    //         div.addClass('d-none');
    //     } 

    };

    // document.querySelectorAll('tr.cachComm').forEach(function (link) {
    //     link.addEventListener('click', onClickBtnComm);
    // });
    document.querySelectorAll('a.b').forEach(function (link) {
        link.addEventListener('click', onClickBtnComm);
    });