//-----------------------------------------------------------------------------------
// Klikne na soubory
//-----------------------------------------------------------------------------------
$("#filesis").click(function()
{
    //$("#frm-inquiryCreateForm-soubory").click();

    if(document.getElementById('frm-inquiryCreateForm-soubory'))
    {
        $("#frm-inquiryCreateForm-soubory").click();
    }
    else
    {
        $("#frm-inquiryEditForm-soubory").click();
    }
})
//-----------------------------------------------------------------------------------
// Zapíše soubory do seznamu
//-----------------------------------------------------------------------------------
updateList = function()
{
    var input = document.getElementById('frm-inquiryCreateForm-soubory');
    if(document.getElementById('frm-inquiryEditForm-soubory'))
    {
        input = document.getElementById('frm-inquiryEditForm-soubory');
    }
    var output = document.getElementById('filesis');

    output.innerHTML = '';
    for (var i = 0; i < input.files.length; ++i)
    {
        //output.innerHTML += '<li class="flex justify-between">' + input.files.item(i).name + '</li>';

        output.innerHTML += '' +
            '<li class="flex justify-between border radius p-1 my-1">' +
            '<div class="">' + input.files.item(i).name + '</div>' +
            '<a href="#" class="delete hover:underline">vymazat</a>' +
            '</li>';
    }
}
//-----------------------------------------------------------------------------------
// Obarvení prioryty
//-----------------------------------------------------------------------------------
changePriorityColor = function()
{
    var input = document.getElementById('frm-inquiryCreateForm-priorities_id');
    if(document.getElementById('frm-inquiryEditForm-priorities_id'))
    {
        input = document.getElementById('frm-inquiryEditForm-priorities_id');
    }

    var output = document.getElementById('priority');

    input.classList.remove("bg-white");
    input.classList.remove("bg-yellow-200");
    input.classList.remove("bg-blue-200");
    input.classList.remove("bg-red-200");

    output.classList.remove("bg-white");
    output.classList.remove("bg-yellow-200");
    output.classList.remove("bg-blue-200");
    output.classList.remove("bg-red-200");

    if (input.options[input.selectedIndex].text === "")
    {
        input.className = input.className + ' bg-white';
        output.className = output.className + ' bg-white';
    }
    else if (input.options[input.selectedIndex].text === "MALÁ")
    {
        input.className = input.className + ' bg-yellow-200';
        output.className = output.className + ' bg-yellow-200';
    }
    else if (input.options[input.selectedIndex].text === "STŘEDNÍ")
    {
        input.className = input.className + ' bg-blue-200';
        output.className = output.className + ' bg-blue-200';
    }
    else if (input.options[input.selectedIndex].text === "VELKÁ")
    {
        input.className = input.className + ' bg-red-200';
        output.className = output.className + ' bg-red-200';
    }
}
//-----------------------------------------------------------------------------------
//
//-----------------------------------------------------------------------------------
changeWeekNum = function()
{
    var input = document.getElementById('frm-inquiryCreateForm-term');
    var output = document.getElementById('frm-inquiryCreateForm-term_week_num');

    if(document.getElementById('frm-inquiryEditForm-term'))
    {
        input = document.getElementById('frm-inquiryEditForm-term');
        output = document.getElementById('frm-inquiryEditForm-term_week_num');
    }

    output.value = new Date(input.value).getWeekNumber();
}

Date.prototype.getWeekNumber = function(){
    var d = new Date(Date.UTC(this.getFullYear(), this.getMonth(), this.getDate()));
    var dayNum = d.getUTCDay() || 7;
    d.setUTCDate(d.getUTCDate() + 4 - dayNum);
    var yearStart = new Date(Date.UTC(d.getUTCFullYear(),0,1));
    return Math.ceil((((d - yearStart) / 86400000) + 1)/7)
};



$(document).ready(function()
{
    $("#add-files").click(function()
    {
        //$("#frm-inquiryCreateForm-files").click();
        //$("#frm-inquiryEditForm-files").click();
        //document.querySelector('.add-files').click();
        $('.add-files').click();
    })

    addFilesToList = function()
    {
        var input = document.querySelector('.add-files');
        var output = document.getElementById('loaded-files'); //$("#loaded-files");

        output.innerHTML = '';
        for (var i = 0; i < input.files.length; ++i)
        {
            console.log(input.files.item(i).name);
            //output.innerHTML += '<li class="flex justify-between">' + input.files.item(i).name + '</li>';

            output.innerHTML += '' +
                '<li class="flex justify-between border radius p-1 my-1">' +
                '<div class="">' + input.files.item(i).name + '</div>' +
                '<div class="">' +  (input.files.item(i).size / (1024*1024)).toFixed(2) + 'MB</div>' +
                '</li>';
        }







        //console.log(input.pathname);
        //document.location.href = input.pathname;
    }
});





























/*$("#frm-inquiryCreateForm-soubory").change(function()
{
    //$("#file-name").text(this.files[0].name);
    //$("#filesis").addClass("bg-gray-200");
    var output = $("#filesis");
    var input = $("#frm-inquiryCreateForm-soubory");
    var fileList = $('#frm-inquiryCreateForm-soubory').prop("files");
    //output.addClass("bg-gray-200");

    for (var i = 0; i < fileList.length; ++i)
    {
        output.innerHTML += '<li>' + input.files.item(i).name + '</li>';
        output.addClass("bg-gray-200");
    }
});*/





/*$('input[type=date]').change(function ()
{
    var output = document.getElementById('filesis');
    var input = document.getElementById('frm-inquiryCreateForm-weeknum');

    output.innerHTML = '';
    for (var i = 0; i < input.files.length; ++i)
    {
        output.innerHTML += '<li>' + this.files.item(i).name + '</li>';
    }
});*/






//-----------------------------------------------------------------------------------
// Zavření chybové hlášky
//-----------------------------------------------------------------------------------
function closeErrorMessage()
{
    var errMsg = document.getElementById("errorMessage");
    errMsg.style.display = none;
}
//-----------------------------------------------------------------------------------
// Načtení obrázku ze složky
//-----------------------------------------------------------------------------------
function openFileBrowser()
{
    var customTxt = document.getElementById("filename");
    var headImg = document.getElementById("image");
    var imgFile = document.getElementById("file");
    imgFile.click();

    imgFile.addEventListener("change", function()
    {
        const file = this.files[0];

        if (file)
        {
            const reader = new FileReader();

            reader.addEventListener("load", function()
            {
                headImg.setAttribute("src", this.result);
            });

            reader.readAsDataURL(file);
        }
        else
        {
            headImg.setAttribute("src", "img/avatars/default-avatar.png");
        }

        if (imgFile.value)
        {
            var fileSource = "img/avatars/" + imgFile.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
            //customTxt.setAttribute('value' , fileSource);
            customTxt.innerHTML = fileSource;
        }
        else
        {
            //customTxt.setAttribute('value' , '');
            customTxt.innerHTML = "Není zvolena žádná fotka.";
        }
    });
}
//-----------------------------------------------------------------------------------
// Načtení obrázku ze složky
//-----------------------------------------------------------------------------------
function openFilesBrowser()
{

    var allfiles = document.getElementById("filesis");
    var selfiles = document.getElementById("file");
    selfiles.click();
}




























//-----------------------------------------------------------------------------------
// Vložení ingredience do listu (enter a insert)
//-----------------------------------------------------------------------------------
function addEnterIngedience()
{
    if(event.keyCode == 13 || event.keyCode == 45)
    {
        addIngredience();
    }
}
//-----------------------------------------------------------------------------------
// Vložení ingredience do listu
//-----------------------------------------------------------------------------------
function addIngredience()
{
    var tbxIngredience = document.getElementById("ingredience");
    var selIngledience = document.getElementById("listIngredience");

    if (!isEmpty(tbxIngredience.value))
    {
        var option = document.createElement("option");
        option.text = tbxIngredience.value;
        selIngledience.add(option);
        tbxIngredience.value = "";
    }

    tbxIngredience.focus();

    setAllIngredients();
}
//-----------------------------------------------------------------------------------
// Vložení ingrediencí do boxu (item|item|item)
//-----------------------------------------------------------------------------------
function setAllIngredients()
{
    var setIngledience = document.getElementById("listIngredience");
    var ingredients = document.getElementById("ingredients");
    var ingr = "";

    Array.from(setIngledience.options).forEach(function(option_element) {
        let option_text = option_element.text;
        //let option_value = option_element.value;
        //let is_option_selected = option_element.selected;
        ingr = ingr + option_text + '|';
    });

    ingredients.setAttribute('value' , ingr.slice(0, -1));
}
//-----------------------------------------------------------------------------------
// Vymazání ingredience z listu (delete)
//-----------------------------------------------------------------------------------
function delDeleteIngedience()
{
    if(event.keyCode == 46)
    {
        delIngredience();
    }
}
//-----------------------------------------------------------------------------------
// Vymazání ingredience z listu
//-----------------------------------------------------------------------------------
function delIngredience()
{
    var selIngledience = document.getElementById("listIngredience");
    selIngledience.remove(selIngledience.selectedIndex);
}
//-----------------------------------------------------------------------------------
// Kontrola hodnoty (true|false)
//-----------------------------------------------------------------------------------
function isEmpty(val)
{
    return (val === undefined || val == null || val.length <= 0) ? true : false;
}

//-----------------------------------------------------------------------------------
// Logout metoda
//-----------------------------------------------------------------------------------
function logoutUser()
{
    event.preventDefault();
    //this.closest('form').submit();
    document.getElementById('logout-form').submit();
}

















$(document).ready(function()
{
    $('#datetime')[0].datetime();
});



/*
 * jQuery DateTime picker plug-in by Drahomir Hanak
 * Is an open-source jQuery plug-in developed for the Saixon corporation. This source code
 * is licensed under the MIT license, and the plug-in is used as a Saixon user interface.
 * Plug-in was tested on jQuery 1.6. If you'd use it, have to let here the comments.
 * (c) 2011 Drahomír Hanák and the Saixon corporation
 *
 * Actual version: 0.9b
 * File name: saixon-ui-datetime.js
 * Public date: November 7th 2011
 * Documentation: English (http://projects.drahak.eu/sui-date-time-picker/)
 * Comments: English
 */

(function( $ ) {

    // Calendar render method
    var Calendar = new function() {

        /** Variables */
        this.cal = null;
        this.calTag = null;
        this.dd = {};
        this.mName = [];
        this.dName = [];
        this.settings = {};

        /** Initialize */
        this.init = function(settings)
        {
            this.settings = settings;
            this.calTag = '.dh_calendar';
            var useable = this.calTag.replace('.', '');
            $(this.settings.handler).after("<div class='"+useable+"'></div>");
            this.cal = $(this.calTag);
            this.dd = this.getDD(this.settings.date);
            this.mName = this.settings.monthNames;
            this.dName = this.settings.dayNames;
            this.cal.css({ display: 'none', marginLeft: this.settings.offsetX, marginTop: this.settings.offsetY });
            this.settings.closeHandler = this.settings.closeHandler == null || this.settings.closeHandler === true ? this.calTag + ' a.dh_close' : this.settings.closeHandler;
        };

        /** Number of days in month */
        this.daysInMonth = function(month, year)
        {
            var m = [31,28,31,30,31,30,31,31,30,31,30,31];
            if(month != 2) return m[month - 1];
            if(year%4 != 0) return m[1];
            if(year%100 == 0 && year%400 != 0) return m[1];
            return m[1] + 1;
        };

        /** Date info */
        this.getDD = function(dateTime)
        {
            var dd = { day: null, month: null, monthNum: null, year: null, daysInMonth: 0, ofWeek: null };
            var date = dateTime ? new Date(dateTime) : new Date();
            dd.day = date.getDate();
            dd.month = date.getMonth();
            dd.monthNum = date.getMonth()+1;
            dd.year = date.getFullYear();
            dd.daysInMonth = this.daysInMonth(dd.monthNum, dd.year);
            dd.ofWeek = this.settings.dayNames[0].substr(0, 3).toLowerCase() == "mon" ? (date.getDay()-1) : date.getDay();
            dd.inWeek = date.getDay();
            dd.serialNumber = this.getSerialNumber(dd.day);
            dd.hour = date.getHours() < 10 ? "0"+date.getHours() : date.getHours();
            dd.minute = date.getMinutes() < 10 ? "0"+date.getMinutes() : date.getMinutes();
            dd.second = date.getSeconds();
            return dd;
        };

        /** Render calendar date */
        this.renderDate = function()
        {
            Calendar.clear();
            var monthName = this.settings.monthNames[this.dd.month];
            var fd = new Date(this.dd.year, this.dd.month, 1);
            var skip = this.settings.dayNames[0].substr(0, 3).toLowerCase() == "mon" ? (fd.getDay()-1) : fd.getDay();
            var prepare = "";
            prepare += "<table>";
            prepare += "<tr>" +
                " <th class='dateFormat dh_prev'><a href='javascript:;'>&lt;&lt;</a></th>" +
                " <th class='dateFormat' colspan='5'>"+monthName+" "+this.dd.year+"</th>" +
                " <th class='dateFormat dh_next'><a href='javascript:;'>&gt;&gt;</a></th>" +
                "</tr><tr class='dh_days'>";
            for(var d = 1; d <= 7; d++) {
                prepare += "<th class='dh_day'>"+this.dName[d-1].substr(0, this.settings.dayShort)+"</th>";
            }
            prepare += "</tr>";
            var actualDay = 0;
            for(var columns = 1; columns <= 6; columns++) {
                prepare += "<tr>";
                for(var week = 1; week <= 7; week++) {
                    if(actualDay < this.dd.daysInMonth) {
                        if(columns > 1 || columns == 1 && week > skip) {
                            actualDay++;
                            activeClass = null;
                            if(this.getDD(null).year == this.dd.year && this.getDD(null).month == this.dd.month && actualDay == this.getDD(null).day) activeClass = 'active';
                            prepare += "<td><a href='javascript:;' class='dh_date "+activeClass+"'>"+(actualDay)+"</td>";
                        } else {
                            prepare += "<td class='dh_empty'></td>";
                        }
                    }
                }
                prepare += "</tr>";
            }
            prepare += "</tr>";
            prepare += "</tr></table>";
            this.cal.append(prepare);

            // toolbar
            this.toolbar();

            // User input
            $(this.settings.closeHandler).click(function(){ Calendar.clear(); Calendar.hide(); });
            $(this.calTag + ' .dh_prev').click(function(){ Calendar.previousMonth(); });
            $(this.calTag + ' .dh_next').click(function(){ Calendar.nextMonth(); });
            $(this.calTag + ' a.dh_date').click(function(){
                var append = Calendar.convert($(this).text(), Calendar.dd.month, Calendar.dd.year);
                if(!Calendar.settings.allowTime) {
                    Calendar.dd.day = $(this).text();
                    $(Calendar.settings.handler).val(append);
                    if(Calendar.settings.closeOnSelect) Calendar.hide();
                    Calendar.settings.selected(Calendar.cal);
                } else {
                    Calendar.dd.day = $(this).text();
                    $(Calendar.calTag + ' table').fadeOut(250, function() {
                        Calendar.renderTime(append);
                    });
                }
            });
        };

        /** Render calendar time */
        this.renderTime = function(date)
        {
            Calendar.clear();
            var prepare = "<table class='dh_time'><tr><th class='dateFormat'>"+date+"</th></tr>" +
                "<tr><td class='timeInputs'>";
            prepare += "<input type='text' value='"+this.dd.hour+"' class='dh_hour' />:" +
                "<input type='text' value='"+this.dd.minute+"' class='dh_minute' /></td></tr>" +
                "</table>";
            this.cal.append(prepare);

            // toolbar
            this.toolbar();

            // User input
            $(this.calTag + ' .dateFormat').click(function(){
                Calendar.clear();
                Calendar.renderDate();
            });
            $(this.calTag + ' input.dh_hour').keyup(function() {
                if($(this).val().toString().length > 2) $(this).val($(this).val().substr(0, 2));
                if(parseInt($(this).val()) > 23) $(this).val(23);
                Calendar.dd.hour = Calendar.isInt($(this).val()) ? $(this).val() : "00";
                Calendar.dd.hour = parseInt(Calendar.dd.hour) < 10 && Calendar.dd.hour.toString().length == 1 ? "0"+Calendar.dd.hour : Calendar.dd.hour;
            });
            $(this.calTag + ' input.dh_minute').keyup(function() {
                if($(this).val().toString().length > 2) $(this).val($(this).val().substr(0, 2));
                if(parseInt($(this).val()) > 59) {
                    $(this).val(00);
                    var val = $(this.calTag + ' input.dh_hour').val();
                    if(parseInt(val) < 23)
                        $(this.calTag + ' input.dh_hour').val((val+1));
                }
                Calendar.dd.minute = Calendar.isInt($(this).val()) ? $(this).val() : "00";
                Calendar.dd.minute = parseInt(Calendar.dd.minute) < 10 && Calendar.dd.minute.toString().length == 1 ? "0"+Calendar.dd.minute : Calendar.dd.minute;
            });
        };

        /** Render toolbar */
        this.toolbar = function()
        {
            if(!this.settings.toolbar) return;
            var prepare = "";
            prepare += "<div class='toolbar'>";
            $.each(this.settings.tc, function(key, value) {
                if(value === true) {
                    var handler;
                    if(key == "close") handler = ["handler_close", Calendar.settings.tcNames.close];
                    else if(key == "today") handler = ["handler_today", Calendar.settings.tcNames.today];
                    else if(key == "submit") handler = ["handler_submit", Calendar.settings.tcNames.submit];
                    else alert('DH datepicker error: Can\'t find handler ' + key);
                    prepare += "<a href='javascript:;' class='"+handler[0]+"'>"+handler[1]+"</a>";
                }
            });
            prepare += "<br style='clear: both;' /></div>";
            this.cal.append(prepare);

            // User input
            $(this.calTag + ' a.handler_close').click(function(){ Calendar.hide(); });
            $(this.calTag + ' a.handler_today').click(function(){
                Calendar.dd = Calendar.getDD(null);
                Calendar.renderDate();
            });
            $(this.calTag + ' a.handler_submit').click(function(){
                $(Calendar.settings.handler).val(Calendar.convert(Calendar.dd.day, Calendar.dd.month, Calendar.dd.year, Calendar.dd.hour, Calendar.dd.minute));
                if(Calendar.settings.closeOnSubmit) Calendar.hide();
                Calendar.settings.selected(Calendar.cal);
            });
        }

        /** Previous month */
        this.previousMonth = function()
        {
            var prevMonth = this.dd.monthNum == 1 ? 12 : (this.dd.monthNum-1);
            var prevYear = prevMonth == 12 ? (this.dd.year-1) : this.dd.year;
            this.dd = this.getDD(prevMonth+'/01/'+prevYear);
            this.clear();
            this.renderDate();
            return true;
        };

        /** Next month */
        this.nextMonth = function()
        {
            var nextMonth = this.dd.monthNum == 12 ? 1 : (this.dd.monthNum+1);
            var nextYear = nextMonth == 1 ? (this.dd.year+1) : this.dd.year;
            this.dd = this.getDD(nextMonth+'/01/'+nextYear);
            this.clear();
            this.renderDate();
        };

        /** Get serial number string */
        this.getSerialNumber = function(day)
        {
            var serialNumber = "th";
            if(day == 1 || day.toString().substr(1) == 1 && day.toString().substr(0, 1) != 1) {
                serialNumber = "st";
            } else if(day == 2 || day.toString().substr(1) == 2 && day.toString().substr(0, 1) != 1) {
                serialNumber = "nd";
            } else if(day == 3 || day.toString().substr(1) == 3 && day.toString().substr(0, 1) != 1) {
                serialNumber = "rd";
            } else {
                serialNumber = "th";
            }
            return serialNumber;
        };

        /** Date string convert */
        this.convert = function(day, month, year, hour, minute)
        {
            day = !day ? this.dd.day : day;
            month = !month ? this.dd.month : month;
            year = !year ? this.dd.year : year;
            hour = !hour ? this.dd.hour : hour;
            minute = !minute ? this.dd.minute : minute;
            var dayIndex = new Date(month, day, year).getDay();
            var jDay = day.toString().length > 1 && parseInt(day) < 10 ? "0"+day : day;
            var gHour = hour.toString().substr(0, 1) == 0 ? hour.toString().substr(1) : hour;
            var glHour = parseInt(hour) > 12 ? (parseInt(hour)-12) : hour;
            var ante = hour > 11 ? this.settings.ante.pm : this.settings.ante.am;
            var date = new Date(month, day, year, hour, minute);
            if(this.settings.format.match("d")) day = day < 10 ? "0"+day : day;
            if(this.settings.format.match("m")) month = month < 10 ? "0"+(month+1) : (month+1);
            return this.settings.format
                // Date format
                .replace("d", day)
                .replace("m", month)
                .replace("j", jDay)
                .replace("n", month)
                .replace("Y", year)
                .replace("S", this.getSerialNumber(day))
                .replace("y", year.toString().substring(2))
                // Time format - ignore settings allowTime
                .replace("H", hour)
                .replace("G", gHour)
                .replace("g", glHour)
                .replace("a", ante.toLowerCase())
                .replace("A", ante.toUpperCase())
                .replace("i", minute)
                // Day and month names
                .replace("F", this.settings.monthNames[month]);
        };

        /** External click
         *  -- TODO
         */
        this.external = function(event)
        {
            var itarget = $(event.target);
            if(itarget[0].tagName != "input") {
                $.each(itarget, function(key, value) {
                    //Calendar.hide();
                });
            }
        };

        /** Is integer */
        this.isInt = function(intVal) {
            var val = intVal;
            return !isNaN(parseInt(val));
        };

        /** Element manipulation functions */
        this.clear = function() { this.cal.html(''); };
        this.show = function() { this.cal.fadeIn(300); };
        this.hide = function() { this.cal.fadeOut(300); };
    }

    // Date picker plug-in
    $.fn.datetime = function(options) {

        /** Settable options */
        var settings = {
            date: null,
            defaultValue: true,
            format: "F jS Y @ g:i a",
            handler: this,
            closeOnSelect: false,
            closeOnSubmit: true,
            allowTime: true,
            toolbar: true,
            tc: { close: true, today: true, submit: true },
            tcNames: { close: "Close", today: "Today", submit: "Submit" },
            offsetX: 2,
            offsetY: 2,
            ante: { pm: "pm", am: "am" },
            dayNames: ["Monday", "Tuesday", "Wendsday", "Thursday", "Friday", "Saturday", "Sunday"],
            monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            dayShort: 3,
            monthShort: 3,
            selected: function(calendar) {}
        };

        // Each element
        return this.each(function() {
            // Make options
            if(options) $.extend( settings, options );
            Calendar.init(settings);

            // On focus active
            $(this).focus(function() {
                Calendar.clear();
                Calendar.renderDate();
                Calendar.show();
            });

            // Close on blur - TODO
            $(document).mousedown(Calendar.external);

            // Default value
            if(settings.defaultValue) {
                if(settings.defaultValue === true)
                    $(settings.handler).val(Calendar.convert());
                else
                    $(settings.handler).val(settings.defaultValue);
            }
        });
    };
})( jQuery );
