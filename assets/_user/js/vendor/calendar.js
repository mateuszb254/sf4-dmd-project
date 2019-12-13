function createCalendar(e, t, a) {
    function n() {
        var a = document.createElement("div");
        a.className += "cld-sidebar";
        var n = document.createElement("ul");
        n.className += "cld-monthList";
        for (var l = 0; l < s.length - 3; l++) {
            var i = document.createElement("li");
            i.className += "cld-month";
            var d = l - (4 - e.Selected.Month);
            if (0 > d ? d += 12 : d > 11 && (d -= 12), 0 == l) i.className += " cld-rwd cld-nav", i.addEventListener("click", function () {
                "function" == typeof e.Options.ModelChange ? e.Model = e.Options.ModelChange() : e.Model = e.Options.ModelChange, createCalendar(e, t, -1)
            }), i.innerHTML += '<svg height="15" width="15" viewBox="0 0 100 75" fill="rgba(255,255,255,0.5)"><polyline points="0,75 100,75 50,0"></polyline></svg>'; else if (l == s.length - 4) i.className += " cld-fwd cld-nav", i.addEventListener("click", function () {
                "function" == typeof e.Options.ModelChange ? e.Model = e.Options.ModelChange() : e.Model = e.Options.ModelChange, createCalendar(e, t, 1)
            }), i.innerHTML += '<svg height="15" width="15" viewBox="0 0 100 75" fill="rgba(255,255,255,0.5)"><polyline points="0,0 100,0 50,75"></polyline></svg>'; else if (4 > l ? i.className += " cld-pre" : l > 4 ? i.className += " cld-post" : i.className += " cld-curr", function () {
                var a = l - 4;
                i.addEventListener("click", function () {
                    "function" == typeof e.Options.ModelChange ? e.Model = e.Options.ModelChange() : e.Model = e.Options.ModelChange, createCalendar(e, t, a)
                }), i.setAttribute("style", "opacity:" + (1 - Math.abs(a) / 4)), i.innerHTML += s[d].substr(0, 3)
            }(), 0 == d) {
                var o = document.createElement("li");
                o.className += "cld-year", 5 > l ? o.innerHTML += e.Selected.Year : o.innerHTML += e.Selected.Year + 1, n.appendChild(o)
            }
            n.appendChild(i)
        }
        a.appendChild(n), e.Options.NavLocation ? (document.getElementById(e.Options.NavLocation).innerHTML = "", document.getElementById(e.Options.NavLocation).appendChild(a)) : t.appendChild(a)
    }

    function l() {
        var a = document.createElement("div");
        if (a.className += "cld-datetime", e.Options.NavShow && !e.Options.NavVertical) {
            var n = document.createElement("div");
            n.className += " cld-rwd cld-nav", n.addEventListener("click", function () {
                createCalendar(e, t, -1)
            }), n.innerHTML = '<svg height="15" width="15" viewBox="0 0 75 100" fill="rgba(0,0,0,0.5)"><polyline points="0,50 75,0 75,100"></polyline></svg>', a.appendChild(n)
        }
        var l = document.createElement("div");
        if (l.className += " today", l.innerHTML = s[e.Selected.Month] + ", " + e.Selected.Year, a.appendChild(l), e.Options.NavShow && !e.Options.NavVertical) {
            var i = document.createElement("div");
            i.className += " cld-fwd cld-nav", i.addEventListener("click", function () {
                createCalendar(e, t, 1)
            }), i.innerHTML = '<svg height="15" width="15" viewBox="0 0 75 100" fill="rgba(0,0,0,0.5)"><polyline points="0,0 75,50 0,100"></polyline></svg>', a.appendChild(i)
        }
        e.Options.DatetimeLocation ? (document.getElementById(e.Options.DatetimeLocation).innerHTML = "", document.getElementById(e.Options.DatetimeLocation).appendChild(a)) : r.appendChild(a)
    }

    function i() {
        var e = document.createElement("ul");
        e.className = "cld-labels";


        if (typeof Translator == "undefined") {
            var t = ["Nd.", "Pon.", "Wt.", "Śr.", "Czw.", "Pt.", "Sob."];
        } else {
            var t = [
                Translator.trans('day7_short', {}, 'date'),
                Translator.trans('day1_short', {}, 'date'),
                Translator.trans('day2_short', {}, 'date'),
                Translator.trans('day3_short', {}, 'date'),
                Translator.trans('day4_short', {}, 'date'),
                Translator.trans('day5_short', {}, 'date'),
                Translator.trans('day6_short', {}, 'date'),
            ];
        }


        for (t, a = 0; a < t.length; a++) {
            var n = document.createElement("li");
            n.className += "cld-label", n.innerHTML = t[a], e.appendChild(n)
        }
        r.appendChild(e)
    }

    function d() {
        function t(e) {
            var t = document.createElement("p");
            return t.className += "cld-number", t.innerHTML += e, t
        }

        var a = document.createElement("ul");
        a.className += "cld-days";
        for (var n = 0; n < e.Selected.FirstDay; n++) {
            var l = document.createElement("li");
            l.className += "cld-day prevMonth";
            for (var i = n % 7, d = 0; d < e.Options.DisabledDays.length; d++) i == e.Options.DisabledDays[d] && (l.className += " disableDay");
            var o = t(e.Prev.Days - e.Selected.FirstDay + (n + 1));
            l.appendChild(o), a.appendChild(l)
        }
        for (var n = 0; n < e.Selected.Days; n++) {
            var l = document.createElement("li");
            l.className += "cld-day currMonth";
            for (var i = (n + e.Selected.FirstDay) % 7, d = 0; d < e.Options.DisabledDays.length; d++) i == e.Options.DisabledDays[d] && (l.className += " disableDay");
            for (var o = t(n + 1), c = 0; c < e.Model.length; c++) {
                var s = e.Model[c].Date, p = new Date(e.Selected.Year, e.Selected.Month, n + 1);
                if (s.getTime() == p.getTime()) {
                    o.className += " eventday";
                    var h = document.createElement("span");
                    if (h.className += "cld-title", "function" == typeof e.Model[c].Link || e.Options.EventClick) {
                        var v = document.createElement("a");
                        if (v.setAttribute("href", "#"), v.innerHTML += e.Model[c].Title, e.Options.EventClick) {
                            var m = e.Model[c].Link;
                            "string" != typeof e.Model[c].Link ? (v.addEventListener("click", e.Options.EventClick.bind.apply(e.Options.EventClick, [null].concat(m))), e.Options.EventTargetWholeDay && (l.className += " clickable", l.addEventListener("click", e.Options.EventClick.bind.apply(e.Options.EventClick, [null].concat(m))))) : (v.addEventListener("click", e.Options.EventClick.bind(null, m)), e.Options.EventTargetWholeDay && (l.className += " clickable", l.addEventListener("click", e.Options.EventClick.bind(null, m))))
                        } else v.addEventListener("click", e.Model[c].Link), e.Options.EventTargetWholeDay && (l.className += " clickable", l.addEventListener("click", e.Model[c].Link));
                        h.appendChild(v)
                    } else h.innerHTML += '<a href="' + e.Model[c].Link + '">' + e.Model[c].Title + "</a>";
                    o.appendChild(h)
                }
            }
            l.appendChild(o), n + 1 == e.Today.getDate() && e.Selected.Month == e.Today.Month && e.Selected.Year == e.Today.Year && (l.className += " today"), a.appendChild(l)
        }
        var y = 13;
        a.children.length > 35 ? y = 6 : a.children.length < 29 && (y = 20);
        for (var n = 0; n < y - e.Selected.LastDay; n++) {
            var l = document.createElement("li");
            l.className += "cld-day nextMonth";
            for (var i = (n + e.Selected.LastDay + 1) % 7, d = 0; d < e.Options.DisabledDays.length; d++) i == e.Options.DisabledDays[d] && (l.className += " disableDay");
            var o = t(n + 1);
            l.appendChild(o), a.appendChild(l)
        }
        r.appendChild(a)
    }

    if ("undefined" != typeof a) {
        var o = new Date(e.Selected.Year, e.Selected.Month + a, 1);
        e = new Calendar(e.Model, e.Options, o), t.innerHTML = ""
    } else for (var c in e.Options) "function" != typeof e.Options[c] && "object" != typeof e.Options[c] && e.Options[c] ? t.className += " " + c + "-" + e.Options[c] : 0;


    if (typeof Translator == "undefined") {
        var s = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Luty", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"];
    } else {
        var s = [
            Translator.trans('month1', {}, 'date'),
            Translator.trans('month2', {}, 'date'),
            Translator.trans('month3', {}, 'date'),
            Translator.trans('month4', {}, 'date'),
            Translator.trans('month5', {}, 'date'),
            Translator.trans('month6', {}, 'date'),
            Translator.trans('month7', {}, 'date'),
            Translator.trans('month8', {}, 'date'),
            Translator.trans('month9', {}, 'date'),
            Translator.trans('month10', {}, 'date'),
            Translator.trans('month11', {}, 'date'),
            Translator.trans('month12', {}, 'date'),
        ];
    }

    r = document.createElement("div");
    r.className += "cld-main", e.Options.Color && (r.innerHTML += "<style>.cld-main{color:" + e.Options.Color + ";}</style>"), e.Options.LinkColor && (r.innerHTML += "<style>.cld-title a{color:" + e.Options.LinkColor + ";}</style>"), t.appendChild(r), e.Options.NavShow && e.Options.NavVertical && n(), e.Options.DateTimeShow && i(), l(), d()
}

function caleandar(e, t, a) {
    var n = new Calendar(t, a);
    createCalendar(n, e)
}

var Calendar = function (e, t, a) {
    this.Options = {
        Color: "",
        LinkColor: "",
        NavShow: !0,
        NavVertical: !1,
        NavLocation: "",
        DateTimeShow: !0,
        DateTimeFormat: "mmm, yyyy",
        DatetimeLocation: "",
        EventClick: "",
        EventTargetWholeDay: !1,
        DisabledDays: [],
        ModelChange: e
    };
    for (var n in t) this.Options[n] = "string" == typeof t[n] ? t[n].toLowerCase() : t[n];
    e ? this.Model = e : this.Model = {}, this.Today = new Date, this.Selected = this.Today, this.Today.Month = this.Today.getMonth(), this.Today.Year = this.Today.getFullYear(), a && (this.Selected = a), this.Selected.Month = this.Selected.getMonth(), this.Selected.Year = this.Selected.getFullYear(), this.Selected.Days = new Date(this.Selected.Year, this.Selected.Month + 1, 0).getDate(), this.Selected.FirstDay = new Date(this.Selected.Year, this.Selected.Month, 1).getDay(), this.Selected.LastDay = new Date(this.Selected.Year, this.Selected.Month + 1, 0).getDay(), this.Prev = new Date(this.Selected.Year, this.Selected.Month - 1, 1), 0 == this.Selected.Month && (this.Prev = new Date(this.Selected.Year - 1, 11, 1)), this.Prev.Days = new Date(this.Prev.getFullYear(), this.Prev.getMonth() + 1, 0).getDate()
};


var events = [
    {
        'Date': new Date('NOW'),
        'Title': 'test_event',
        'Link': '#'
    },
];


var settings = {
    Color: '',
    LinkColor: '',
    NavShow: true,
    NavVertical: false,
    NavLocation: '',
    DateTimeShow: true,
    DateTimeFormat: 'mmm, yyyy',
    DatetimeLocation: '',
    EventClick: '',
    EventTargetWholeDay: false,
    DisabledDays: [],
};

caleandar(document.getElementById('calendar'), events, settings);
