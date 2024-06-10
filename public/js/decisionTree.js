var treeData, windowWidth, sliderWidth, slideTime, branches;

function debug(str) {
    $('#debug').append(str + '<br />');
}

function loadData(id, modelNo) {
    $.ajax({
        type: 'GET',
        url: 'public/xml/tree' + id + '.xml',
        dataType: 'xml',
        success: function (xml) {
            if (xml) {
                buildNodes(xml, id, modelNo);
            } else {
                toastr.options.closeButton = true
                toastr.options.tapToDismiss = true
                toastr.options.timeOut = 0
                toastr.options.extendedTimeOut = 0
                toastr.error("No data available")
                return false;
            }
        }, error: function () {
            toastr.options.closeButton = true
            toastr.options.tapToDismiss = true
            toastr.options.timeOut = 0
            toastr.options.extendedTimeOut = 0
            toastr.error("No data available")
            return false;
        }
    });
}

function TreeBranch() {
    this.id = '';
    this.content = '';
    this.forkIDs = [];
    this.forkLabels = [];
}

function buildNodes(xmlData, id, modelNo) {
    localStorage.setItem("treeId", id);
    localStorage.setItem("modelNo", modelNo);
    var tkt = localStorage.getItem("ticketNo");
    var serviceNo = localStorage.getItem("service");
    var mobileNo = localStorage.getItem("mobile");
    var maxDepth = 0;
    branches = [];
    treeData = xmlData;
    $(xmlData).find('branch').each(
        function () {
            var branch = new TreeBranch();
            branch.id = $(this).attr('id');
            branch.content = $(this).find('content').text();
            branch.image = $(this).find('image').text();
            $(this).find('fork').each(
                function () {
                    branch.forkIDs.push($(this).attr('target'));
                    branch.forkLabels.push($(this).text());
                }
            );
            branches.push(branch);

        });
    var resetText = $(xmlData).find('resetText').text();
    if (resetText !== '') {
        $('#tree-reset').html(resetText);
    } else {
        $('#tree-reset').remove();
    }
    var treeName = $(xmlData).find('title').text();
    localStorage.setItem("treeName", treeName);
    if ($(xmlData).find('disclaimer').length) {
        var _token = $('input[name="_token"]').val();
        $(".treeList").hide();
        $(".ticketclass").hide();
        $('.app-title, title').text($(xmlData).find('title').text());
        $('#tree-slider-1').append('<div class="info-wrapper-1"><span class="lead">' + $(xmlData).find('description').text() + '</span></div>');
        $('.info-wrapper-1').append('<br /><br /><u><b>Disclaimer</b></u><br><br>');
        $('.info-wrapper-1').append('<span class="lead">' + $(xmlData).find('disclaimer').text() + '</span>')
            .append('<div class="checkbox"> <label> <input type="checkbox" id="agree"> I agree.</label> </div>');
        $('#tree-window-1 #agree').on('change', function (event) {
            $('.info-wrapper-1').remove();
            $.ajax({
                url: BASEURL + "/saveFootPrint",
                type: "POST",
                data: {
                    node: "Disclaimer",
                    tree_id: id,
                    tree_name: treeName,
                    description: "No Description",
                    model_number: modelNo,
                    ticket_number: tkt,
                    service_number: serviceNo,
                    mobile_number: mobileNo,
                    _token: _token
                },
                success: function (response) {
                    showBranch(1);
                    $('.reset-container').show();

                },
            });
        });

    } else {
        $('#tree-slider-1').append('<div class="info-wrapper-1"><br /><br /><button type="button" class="btn btn-primary begin-tree">Begin</button></div>')
        $('#tree-window-1 .begin-tree').on('click', function (event) {
            event.preventDefault();
            $('.info-wrapper-1').remove();
            $.ajax({
                url: BASEURL + "/saveFootPrint",
                type: "POST",
                data: {
                    node: "Disclaimer",
                    tree_id: id,
                    tree_name: treeName,
                    description: "No Description",
                    model_number: modelNo,
                    ticket_number: tkt,
                    service_number: serviceNo,
                    mobile_number: mobileNo,
                    _token: _token
                },
                success: function (response) {
                    showBranch(1);
                    $('.reset-container').show();

                },
            });
        });
    }
}

function resetActionLinks(scanTxt) {
    var _token = $('input[name="_token"]').val();
    $('.decision-links a').unbind('click');
    $('a.back-link').unbind('click');
    var treeId = localStorage.getItem("treeId");
    var treeName = localStorage.getItem("treeName");
    var modelNo = localStorage.getItem("modelNo");
    var tkt = localStorage.getItem("ticketNo");
    var serviceNo = localStorage.getItem("service");
    var mobileNo = localStorage.getItem("mobile");
    $('.decision-links a').click(function (e) {
        if (!$(this).attr('href')) {
            showBranch($(this).attr('id'));
            var hrefText = $(this).text();
            $.ajax({
                url: BASEURL + "/saveFootPrint",
                type: "POST",
                data: {
                    node: hrefText,
                    tree_id: treeId,
                    tree_name: treeName,
                    description: scanTxt,
                    model_number: modelNo,
                    ticket_number: tkt,
                    service_number: serviceNo,
                    mobile_number: mobileNo,
                    _token: _token
                },
                success: function (response) {

                    console.log("successfully save");

                },
            });

        }
    });
    $('.back-link').click(function () {
        //showBranch($(this).id);
        //alert($(this).attr('id'))
        //$('#branch-' + $(this).attr('id')).hide();
        // $('#branch-' + $(this).attr('id')).parent().show();
        // $('#branch-' + $(this).attr('id')).prev('.tree-content-box-1').show();
        //textfun($(this).attr('id'));
        var str = $(this).attr('id');
        var res = str.split(".");
        popped = res.pop();
        separator = '.';
        LastId = res.join(separator);
        //alert(LastId)
        document.getElementById('branch-' + LastId).style.display = "block";
        document.getElementById('branch-' + $(this).attr('id')).remove();
    });
    $('.lastback').click(function () {
        $('#saveImageData').hide();
        $('#allTree').show();
    });
}

function showBranch(id) {
    var currentBranch;
    var treeId = localStorage.getItem("treeId");
    var modelNo = localStorage.getItem("modelNo");
    var ticketNo = localStorage.getItem("ticketNo");
    var serviceNo = localStorage.getItem("service");
    var mobileNo = localStorage.getItem("mobile");
    var treeName = localStorage.getItem("treeName");
    for (var i = 0; i < branches.length; i++) {
        if (branches[i].id == id) {
            currentBranch = branches[i];
            break;
        }
    }
    var decisionLinksHTML = '<br><div class="decision-links">';
    for (var d = 0; d < currentBranch.forkIDs.length; d++) {
        var link = '';
        var forkContent = $(treeData).find('branch[id="' + currentBranch.forkIDs[d] + '"]').find('content').text();
        if (forkContent.indexOf('http://') == 0 || forkContent.indexOf('https://') == 0) {
            link = 'href="' + forkContent + '"';
        }
        decisionLinksHTML += '<a ' + link + ' id="' + currentBranch.forkIDs[d] + '" onclick=textfun("' + currentBranch.id + '");>' + currentBranch.forkLabels[d] + '</a>  | ';
    }
    decisionLinksHTML += '</div><br><br>';
    if (currentBranch.forkIDs.length == 0) {
        $('#tree_id').val(treeId);
        $('#model_number').val(modelNo);
        $('#ticket_name').val(ticketNo);
        $('#mobile_number').val(mobileNo);
        $('#service_number').val(serviceNo);
        $('#tree_name').val(treeName);
        $('#saveImageData').show();
        $('#allTree').hide();
    } else {
        $('#saveImageData').hide();
    }
    //insert referral link here    
    if (currentBranch.image) {
        var imageP = '<br><p><img src=public/images/branch/' + currentBranch.image + ' style="width: 90%;height:20%;"></p>';
    } else {
        var imageP = "";
    }
    var scanTxt;
    scanTxt = currentBranch.content.replace('{{', '<a class="referral-link" href="https://google.com">').replace('}}', '</a>');
    var branchHTML = '<div id="branch-' + currentBranch.id + '" class="tree-content-box-1 hideData"><div class="content">' + scanTxt + '</div>' + imageP + decisionLinksHTML;
    if (currentBranch.id !== 1) {
        //branchHTML += '<a  onclick="javascript: history.back();">&laquo; Back</a>';
        branchHTML += '<a class="back-link" id="' + currentBranch.id + '";>&laquo; Back</a>';
    }
    branchHTML += '</div>';
    $('#tree-slider-1').append(branchHTML);
    resetActionLinks(scanTxt);
}

function areCookiesEnabled() {
    var cookieEnabled = (navigator.cookieEnabled) ? true : false;

    if (typeof navigator.cookieEnabled == "undefined" && !cookieEnabled) {
        document.cookie = "testcookie";
        cookieEnabled = (document.cookie.indexOf("testcookie") != -1) ? true : false;
    }
    return (cookieEnabled);
}

function textfun(id) {
    document.getElementById('branch-' + id).style.display = "none";
    $('.hideData').hide();

}

function addReferralListeners() {

    //$('.panel-default').hide();

    $('.ref-toggle').click(function (e) {
        $('.ref-chooser').removeClass('hidden');
    });

    //Add listener for user change
    $('#refSubmit').click(function (e) {
        e.preventDefault();
        generateReferralManual($('#zipCode').val(), $('#geoRange').val());

    });

    //Add listener for user referral click
    $('.click-through').click(function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var refId = $(this).attr('data-id');
        var user = $.cookie('idt-user');
        var sess = $.cookie('idt-sess-id');
        var thisIsAPhone = false;
        if ($(this).hasClass('phone-link')) {
            thisIsAPhone = true;
        }

        $.post('private/backend.php', { 'action': 'link_click', 'referral_id': refId, 'sess_id': sess, 'user_id': user }, function (data) {

            if (thisIsAPhone) {
                var strip = url.replace(/[^a-zA-Z\d:]/g, '');
                window.open(strip, '_system');
            } else {
                window.open(url, '_system', 'location=yes');
                //navigator.app.loadUrl(url, { openExternal:true });
            }
        });
    });

}

function generateReferralManual(zip, distance) {

    var url = 'private/referral.php?zip=' + zip + '&geo_range=' + distance;
    $('#tree-slider').load(url, function () {
        $('#zipCode').val(zip);
        $('#geoRange').val(distance);
        addReferralListeners();
    });
}

function generateReferralGeo() {
    var sessId = $.cookie('idt-sess-id');

    $('#tree-slider').html('Attempting to get your location.');
    navigator.geolocation.getCurrentPosition(function succcess(position) {
        $.post('private/backend.php', {
            action: 'update_location',
            lat: position.coords.latitude,
            long: position.coords.longitude,
            user_id: $.cookie('idt-user')
        }, function (e) {
            $('#tree-slider').html('Finding referrals for you.');
        });
        $('#tree-slider').load('private/referral.php?sess_id=' + sessId, function () {
            addReferralListeners();
            $('.list-group').width($('#tree-window').width());
            $('#zipCode').attr('placeholder', 'Please Provide Zip Code');
            $('#tree-window').scrollTo(0 + 'px', {
                axis: 'x',
                duration: slideTime,
                easing: 'easeInOutExpo',
                onAfter: function () {
                    $('.tree-content-box:gt(0)').remove();
                }
            });
            $('#tree-window').css({ 'overflow-y': 'scroll' });
        });
    }, function fail() {
        var zipForm = '<h3>Geolocation is unavailable.</h3>' +
            '<form name="zip_only"><input type="number" name="zip" placeholder="Enter Your Zip Code"><button type="submit">Go</button></form>';
        $('#tree-slider').html(zipForm);
        $('#tree-window').scrollTo(0 + 'px', {
            axis: 'x',
            duration: slideTime,
            easing: 'easeInOutExpo',
            onAfter: function () {
                $('.tree-content-box:gt(0)').remove();
            }
        });
        $('form[name="zip_only"]').submit(function (e) {
            e.preventDefault();
            var userZip = $(this).find('input').val();
            generateReferralManual(userZip, '105600');
        });
    },
        { maximumAge: 3000, timeout: 5000, enableHighAccuracy: true }
    );

}

