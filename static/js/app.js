var app = {
    
    ratio: {},
    
    ratioList: [],
    
    setRatio: function(i) {
        app.ratio = app.ratioList[i];
        app.ratio.i = i;
        app.ratio.constrain = true;
        app.ratio.dataWidth = app.ratio.width;
        app.ratio.dataHeight = app.ratio.height;
    },
    
    addRatioListModal: function() {
        $('#modal-add-aspect-ratio').modal('show');
        $('#modal-add-aspect-ratio').on('shown.bs.modal', function (e) {
            $('#custom_ratio_width').focus();
        });
    },
    
    addRatioListItem: function() {
        var customRatioWidth = parseInt($('#custom_ratio_width').val() * 1);
        var customRatioHeight = parseInt($('#custom_ratio_height').val() * 1);
        var customRatioName = $('#custom_ratio_name').val();
        if(customRatioWidth > 0 && customRatioHeight > 0) {
            app.ratioList.push({ width: customRatioWidth, height: customRatioHeight, name: customRatioName });
            storage.set('ratioList', JSON.stringify(app.ratioList));
            $('#custom_ratio_width').val('');
            $('#custom_ratio_height').val('');
            $('#custom_ratio_name').val('');
        }
        app.ratioListGenerateButtons();
        app.selectRatioListItem(app.ratioList.length - 1);
        $('#modal-add-aspect-ratio').modal('hide');
    },
    
    selectRatioListItem: function(i) {
        app.setRatio(i);
        app.recalculate();
    },
    
    ratioListGenerateButtons: function() {
        $('#ratios').html('');
        for(var i in app.ratioList) {
            var r = app.ratioList[i];
            $('#ratios').append('<button type="button" class="btn btn-default ratio_list" id="ratio_list_'+i+'" onclick="app.selectRatioListItem('+i+')">'+r.width+':'+r.height+' '+r.name+'</button>');
        }
        $('#ratios').append('<button type="button" class="btn btn-default" onclick="app.addRatioListModal()">Add Custom</button>');
    },
    
    recalculate: function(changed) {
        console.log(app.ratio);
        if(app.ratio.constrain) {
            if(changed === 'width') {
                app.ratio.dataHeight = app.ratio.dataWidth / (app.ratio.width / app.ratio.height);
            } else {
                app.ratio.dataWidth = app.ratio.dataHeight * (app.ratio.width / app.ratio.height);
            }
        }
        var r = app.gcd(app.ratio.dataWidth, app.ratio.dataHeight);
        app.ratio.width = app.ratio.dataWidth / r;
        app.ratio.height = app.ratio.dataHeight / r;
        app.setCalculationElementsValue();
        //app.selectRatioListItem(app.ratio.i);
    },
    
    gcd: function(a, b) {
        return (b === 0) ? a : app.gcd(b, a%b);
    },
    
    setCalculationElementsValue: function() {
        if(app.ratio.constrain) {
            $('#ratio_constrain').prop('checked', true);
        } else {
            $('#ratio_constrain').prop('checked', false);
        }
        $('#ratio_width').val(app.ratio.dataWidth);
        $('#ratio_width_range').val(app.ratio.dataWidth);
        $('#ratio_height').val(app.ratio.dataHeight);
        $('#ratio_height_range').val(app.ratio.dataHeight);
        var ratioText = app.ratio.width+':'+app.ratio.height;
        $('#ratio_ratio').val(ratioText);
        $('#preview').height(app.ratio.height * 10).width(app.ratio.width * 10);
        $('#preview p').html(ratioText);
        
        $('.ratio_list').removeClass('active');
        $('#ratio_list_'+app.ratio.i).addClass('active');
    },
    
    init: function() {
        app.ratioList = JSON.parse(storage.get('ratioList'));
        console.log(app.ratioList);
        if(app.ratioList === '' || app.ratioList === null) {
            app.ratioList =[
                { width: 1, height: 1, name: 'Standard' },
                { width: 4, height: 3, name: 'Standard' },
                { width: 16, height: 9, name: 'Widescreen' }
            ];
            storage.set('ratioList', JSON.stringify(app.ratioList));
        }
        
        app.ratioListGenerateButtons();
        app.selectRatioListItem(0);
        
        // Add new ratio form submit
        $('#custom_ratio_form').on('submit', function(e) {
            app.addRatioListItem();
            e.preventDefault();
            return false;
        });
        
        // Recalculate events
        $('#ratio_constrain').on('click', function() {
            if($(this).is(':checked')) {
                app.ratio.constrain = true;
            } else {
                app.ratio.constrain = false;
            }
        });
        $('#ratio_width, #ratio_width_range').on('change blur keyup keydown mouseclick', function() {
            app.ratio.dataWidth = $(this).val();
            app.recalculate('width');
        });
        $('#ratio_height, #ratio_height_range').on('change blur keyup keydown mouseclick', function() {
            app.ratio.dataHeight = $(this).val();
            app.recalculate('height');
        });
        
        $('[data-toggle="tooltip"]').tooltip();
    }
    
};

var storage = {
    set: function(key, value) {
        if (typeof (Storage) !== "undefined") {
            localStorage.setItem(key, value);
            return true;
        }
        return false;
    },
    get: function(key) {
        if (typeof (Storage) !== "undefined") {
            return localStorage.getItem(key);
        }
        return '';
    }
};

$( function() {
    app.init();
});