function d_home(){
    $('#homep').show();
    $('#marketp').hide();
    $('#bidsp').hide();
    $('#transp').hide();
    $('#newsp').hide();
    $('#companyp').hide();
    $('#rulep').hide();
    
    $('#m_home').addClass("active");
    $('#m_market').removeClass("active");
    $('#m_bids').removeClass("active");
    $('#m_trans').removeClass("active");
    $('#m_news').removeClass("active");
    $('#m_comp').removeClass("active");
    $('#m_rules').removeClass("active");
}

function d_market(){
    $('#homep').hide();
    $('#marketp').show();
    $('#transp').hide();
    $('#bidsp').hide();
    $('#newsp').hide();
    $('#companyp').hide();
    $('#rulep').hide();
    
    $('#m_home').removeClass("active");
    $('#m_market').addClass("active");
    $('#m_trans').removeClass("active");
    $('#m_bids').removeClass("active");
    $('#m_news').removeClass("active");
    $('#m_comp').removeClass("active");
    $('#m_rules').removeClass("active");
}

function d_bids(){
    $('#homep').hide();
    $('#marketp').hide();
    $('#bidsp').show();
    $('#transp').hide();
    $('#newsp').hide();
    $('#companyp').hide();
    $('#rulep').hide();
    
    $('#m_home').removeClass("active");
    $('#m_market').removeClass("active");
    $('#m_bids').addClass("active");
    $('#m_trans').removeClass("active");
    $('#m_news').removeClass("active");
    $('#m_comp').removeClass("active");
    $('#m_rules').removeClass("active");
}

function d_trans(){
    $('#homep').hide();
    $('#marketp').hide();
    $('#bidsp').hide();
    $('#transp').show();
    $('#newsp').hide();
    $('#companyp').hide();
    $('#rulep').hide();
    
    $('#m_home').removeClass("active");
    $('#m_market').removeClass("active");
    $('#m_bids').removeClass("active");
    $('#m_trans').addClass("active");
    $('#m_news').removeClass("active");
    $('#m_comp').removeClass("active");
    $('#m_rules').removeClass("active");
}

function d_news(){
    $('#homep').hide();
    $('#marketp').hide();
    $('#bidsp').hide();
    $('#transp').hide();
    $('#newsp').show();
    $('#companyp').hide();
    $('#rulep').hide();
    
    $('#m_home').removeClass("active");
    $('#m_market').removeClass("active");
    $('#m_bids').removeClass("active");
    $('#m_trans').removeClass("active");
    $('#m_news').addClass("active");
    $('#m_comp').removeClass("active");
    $('#m_rules').removeClass("active");
}

function d_comp(){
    $('#homep').hide();
    $('#marketp').hide();
    $('#bidsp').hide();
    $('#transp').hide();
    $('#newsp').hide();
    $('#companyp').show();
    $('#rulep').hide();
    
    $('#m_home').removeClass("active");
    $('#m_market').removeClass("active");
    $('#m_bids').removeClass("active");
    $('#m_trans').removeClass("active");
    $('#m_news').removeClass("active");
    $('#m_comp').addClass("active");
    $('#m_rules').removeClass("active");
}

function d_rules(){
    $('#homep').hide();
    $('#marketp').hide();
    $('#bidsp').hide();
    $('#transp').hide();
    $('#newsp').hide();
    $('#companyp').hide();
    $('#rulep').show();
    
    $('#m_home').removeClass("active");
    $('#m_market').removeClass("active");
    $('#m_bids').removeClass("active");
    $('#m_trans').removeClass("active");
    $('#m_news').removeClass("active");
    $('#m_comp').removeClass("active");
    $('#m_rules').addClass("active");
}

$(function () {
    //Widgets count
    $('.count-to').countTo();

    //Sales count to
    $('.sales-count-to').countTo({
        formatter: function (value, options) {
            return '$' + value.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, ' ').replace('.', ',');
        }
    });

    initRealTimeChart();
    initDonutChart();
    initSparkline();
});