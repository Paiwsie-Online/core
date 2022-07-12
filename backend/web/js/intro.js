/*!
 * Intro.js v4.2.2
 * https://introjs.com
 *
 * Copyright (C) 2012-2021 Afshin Mehrabani (@afshinmeh).
 * https://raw.githubusercontent.com/usablica/intro.js/master/license.md
 *
 * Date: Fri, 27 Aug 2021 12:07:05 GMT
 */
!(function (t, e) {
    "object" == typeof exports && "undefined" != typeof module ? (module.exports = e()) : "function" == typeof define && define.amd ? define(e) : ((t = "undefined" != typeof globalThis ? globalThis : t || self).introJs = e());
})(this, function () {
    "use strict";
    function t(e) {
        return (t =
            "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
                ? function (t) {
                    return typeof t;
                }
                : function (t) {
                    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
                })(e);
    }
    var e = (function () {
        var t = {};
        return function (e) {
            var n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "introjs-stamp";
            return (t[n] = t[n] || 0), void 0 === e[n] && (e[n] = t[n]++), e[n];
        };
    })();
    function n(t, e, n) {
        if (t) for (var i = 0, o = t.length; i < o; i++) e(t[i], i);
        "function" == typeof n && n();
    }
    var i = new (function () {
            var t = "introjs_event";
            (this._id = function (t, n, i, o) {
                return n + e(i) + (o ? "_".concat(e(o)) : "");
            }),
                (this.on = function (e, n, i, o, r) {
                    var l = this._id.apply(this, arguments),
                        a = function (t) {
                            return i.call(o || e, t || window.event);
                        };
                    "addEventListener" in e ? e.addEventListener(n, a, r) : "attachEvent" in e && e.attachEvent("on".concat(n), a), (e[t] = e[t] || {}), (e[t][l] = a);
                }),
                (this.off = function (e, n, i, o, r) {
                    var l = this._id.apply(this, arguments),
                        a = e[t] && e[t][l];
                    a && ("removeEventListener" in e ? e.removeEventListener(n, a, r) : "detachEvent" in e && e.detachEvent("on".concat(n), a), (e[t][l] = null));
                });
        })(),
        o = "undefined" != typeof globalThis ? globalThis : "undefined" != typeof window ? window : "undefined" != typeof global ? global : "undefined" != typeof self ? self : {};
    function r(t, e) {
        return t((e = { exports: {} }), e.exports), e.exports;
    }
    var l,
        a,
        s = function (t) {
            return t && t.Math == Math && t;
        },
        c =
            s("object" == typeof globalThis && globalThis) ||
            s("object" == typeof window && window) ||
            s("object" == typeof self && self) ||
            s("object" == typeof o && o) ||
            (function () {
                return this;
            })() ||
            Function("return this")(),
        u = function (t) {
            try {
                return !!t();
            } catch (t) {
                return !0;
            }
        },
        h = !u(function () {
            return (
                7 !=
                Object.defineProperty({}, 1, {
                    get: function () {
                        return 7;
                    },
                })[1]
            );
        }),
        f = {}.propertyIsEnumerable,
        p = Object.getOwnPropertyDescriptor,
        d = {
            f:
                p && !f.call({ 1: 2 }, 1)
                    ? function (t) {
                        var e = p(this, t);
                        return !!e && e.enumerable;
                    }
                    : f,
        },
        g = function (t, e) {
            return { enumerable: !(1 & t), configurable: !(2 & t), writable: !(4 & t), value: e };
        },
        v = {}.toString,
        m = function (t) {
            return v.call(t).slice(8, -1);
        },
        b = "".split,
        y = u(function () {
            return !Object("z").propertyIsEnumerable(0);
        })
            ? function (t) {
                return "String" == m(t) ? b.call(t, "") : Object(t);
            }
            : Object,
        w = function (t) {
            if (null == t) throw TypeError("Can't call method on " + t);
            return t;
        },
        _ = function (t) {
            return y(w(t));
        },
        x = function (t) {
            return "object" == typeof t ? null !== t : "function" == typeof t;
        },
        j = function (t) {
            return "function" == typeof t ? t : void 0;
        },
        C = function (t, e) {
            return arguments.length < 2 ? j(c[t]) : c[t] && c[t][e];
        },
        S = C("navigator", "userAgent") || "",
        E = c.process,
        A = c.Deno,
        k = (E && E.versions) || (A && A.version),
        T = k && k.v8;
    T ? (a = (l = T.split("."))[0] < 4 ? 1 : l[0] + l[1]) : S && (!(l = S.match(/Edge\/(\d+)/)) || l[1] >= 74) && (l = S.match(/Chrome\/(\d+)/)) && (a = l[1]);
    var N = a && +a,
        I =
            !!Object.getOwnPropertySymbols &&
            !u(function () {
                var t = Symbol();
                return !String(t) || !(Object(t) instanceof Symbol) || (!Symbol.sham && N && N < 41);
            }),
        O = I && !Symbol.sham && "symbol" == typeof Symbol.iterator,
        P = O
            ? function (t) {
                return "symbol" == typeof t;
            }
            : function (t) {
                var e = C("Symbol");
                return "function" == typeof e && Object(t) instanceof e;
            },
        L = function (t, e) {
            try {
                Object.defineProperty(c, t, { value: e, configurable: !0, writable: !0 });
            } catch (n) {
                c[t] = e;
            }
            return e;
        },
        q = "__core-js_shared__",
        R = c[q] || L(q, {}),
        M = r(function (t) {
            (t.exports = function (t, e) {
                return R[t] || (R[t] = void 0 !== e ? e : {});
            })("versions", []).push({ version: "3.16.1", mode: "global", copyright: "© 2021 Denis Pushkarev (zloirock.ru)" });
        }),
        B = function (t) {
            return Object(w(t));
        },
        H = {}.hasOwnProperty,
        $ =
            Object.hasOwn ||
            function (t, e) {
                return H.call(B(t), e);
            },
        D = 0,
        F = Math.random(),
        z = function (t) {
            return "Symbol(" + String(void 0 === t ? "" : t) + ")_" + (++D + F).toString(36);
        },
        W = M("wks"),
        V = c.Symbol,
        U = O ? V : (V && V.withoutSetter) || z,
        G = function (t) {
            return ($(W, t) && (I || "string" == typeof W[t])) || (I && $(V, t) ? (W[t] = V[t]) : (W[t] = U("Symbol." + t))), W[t];
        },
        Y = G("toPrimitive"),
        K = function (t, e) {
            if (!x(t) || P(t)) return t;
            var n,
                i = t[Y];
            if (void 0 !== i) {
                if ((void 0 === e && (e = "default"), (n = i.call(t, e)), !x(n) || P(n))) return n;
                throw TypeError("Can't convert object to primitive value");
            }
            return (
                void 0 === e && (e = "number"),
                    (function (t, e) {
                        var n, i;
                        if ("string" === e && "function" == typeof (n = t.toString) && !x((i = n.call(t)))) return i;
                        if ("function" == typeof (n = t.valueOf) && !x((i = n.call(t)))) return i;
                        if ("string" !== e && "function" == typeof (n = t.toString) && !x((i = n.call(t)))) return i;
                        throw TypeError("Can't convert object to primitive value");
                    })(t, e)
            );
        },
        X = function (t) {
            var e = K(t, "string");
            return P(e) ? e : String(e);
        },
        J = c.document,
        Q = x(J) && x(J.createElement),
        Z = function (t) {
            return Q ? J.createElement(t) : {};
        },
        tt =
            !h &&
            !u(function () {
                return (
                    7 !=
                    Object.defineProperty(Z("div"), "a", {
                        get: function () {
                            return 7;
                        },
                    }).a
                );
            }),
        et = Object.getOwnPropertyDescriptor,
        nt = {
            f: h
                ? et
                : function (t, e) {
                    if (((t = _(t)), (e = X(e)), tt))
                        try {
                            return et(t, e);
                        } catch (t) {}
                    if ($(t, e)) return g(!d.f.call(t, e), t[e]);
                },
        },
        it = function (t) {
            if (!x(t)) throw TypeError(String(t) + " is not an object");
            return t;
        },
        ot = Object.defineProperty,
        rt = {
            f: h
                ? ot
                : function (t, e, n) {
                    if ((it(t), (e = X(e)), it(n), tt))
                        try {
                            return ot(t, e, n);
                        } catch (t) {}
                    if ("get" in n || "set" in n) throw TypeError("Accessors not supported");
                    return "value" in n && (t[e] = n.value), t;
                },
        },
        lt = h
            ? function (t, e, n) {
                return rt.f(t, e, g(1, n));
            }
            : function (t, e, n) {
                return (t[e] = n), t;
            },
        at = Function.toString;
    "function" != typeof R.inspectSource &&
    (R.inspectSource = function (t) {
        return at.call(t);
    });
    var st,
        ct,
        ut,
        ht = R.inspectSource,
        ft = c.WeakMap,
        pt = "function" == typeof ft && /native code/.test(ht(ft)),
        dt = M("keys"),
        gt = function (t) {
            return dt[t] || (dt[t] = z(t));
        },
        vt = {},
        mt = "Object already initialized",
        bt = c.WeakMap;
    if (pt || R.state) {
        var yt = R.state || (R.state = new bt()),
            wt = yt.get,
            _t = yt.has,
            xt = yt.set;
        (st = function (t, e) {
            if (_t.call(yt, t)) throw new TypeError(mt);
            return (e.facade = t), xt.call(yt, t, e), e;
        }),
            (ct = function (t) {
                return wt.call(yt, t) || {};
            }),
            (ut = function (t) {
                return _t.call(yt, t);
            });
    } else {
        var jt = gt("state");
        (vt[jt] = !0),
            (st = function (t, e) {
                if ($(t, jt)) throw new TypeError(mt);
                return (e.facade = t), lt(t, jt, e), e;
            }),
            (ct = function (t) {
                return $(t, jt) ? t[jt] : {};
            }),
            (ut = function (t) {
                return $(t, jt);
            });
    }
    var Ct,
        St = {
            set: st,
            get: ct,
            has: ut,
            enforce: function (t) {
                return ut(t) ? ct(t) : st(t, {});
            },
            getterFor: function (t) {
                return function (e) {
                    var n;
                    if (!x(e) || (n = ct(e)).type !== t) throw TypeError("Incompatible receiver, " + t + " required");
                    return n;
                };
            },
        },
        Et = r(function (t) {
            var e = St.get,
                n = St.enforce,
                i = String(String).split("String");
            (t.exports = function (t, e, o, r) {
                var l,
                    a = !!r && !!r.unsafe,
                    s = !!r && !!r.enumerable,
                    u = !!r && !!r.noTargetGet;
                "function" == typeof o && ("string" != typeof e || $(o, "name") || lt(o, "name", e), (l = n(o)).source || (l.source = i.join("string" == typeof e ? e : ""))),
                    t !== c ? (a ? !u && t[e] && (s = !0) : delete t[e], s ? (t[e] = o) : lt(t, e, o)) : s ? (t[e] = o) : L(e, o);
            })(Function.prototype, "toString", function () {
                return ("function" == typeof this && e(this).source) || ht(this);
            });
        }),
        At = Math.ceil,
        kt = Math.floor,
        Tt = function (t) {
            return isNaN((t = +t)) ? 0 : (t > 0 ? kt : At)(t);
        },
        Nt = Math.min,
        It = function (t) {
            return t > 0 ? Nt(Tt(t), 9007199254740991) : 0;
        },
        Ot = Math.max,
        Pt = Math.min,
        Lt = function (t, e) {
            var n = Tt(t);
            return n < 0 ? Ot(n + e, 0) : Pt(n, e);
        },
        qt = function (t) {
            return function (e, n, i) {
                var o,
                    r = _(e),
                    l = It(r.length),
                    a = Lt(i, l);
                if (t && n != n) {
                    for (; l > a; ) if ((o = r[a++]) != o) return !0;
                } else for (; l > a; a++) if ((t || a in r) && r[a] === n) return t || a || 0;
                return !t && -1;
            };
        },
        Rt = { includes: qt(!0), indexOf: qt(!1) },
        Mt = Rt.indexOf,
        Bt = function (t, e) {
            var n,
                i = _(t),
                o = 0,
                r = [];
            for (n in i) !$(vt, n) && $(i, n) && r.push(n);
            for (; e.length > o; ) $(i, (n = e[o++])) && (~Mt(r, n) || r.push(n));
            return r;
        },
        Ht = ["constructor", "hasOwnProperty", "isPrototypeOf", "propertyIsEnumerable", "toLocaleString", "toString", "valueOf"],
        $t = Ht.concat("length", "prototype"),
        Dt = {
            f:
                Object.getOwnPropertyNames ||
                function (t) {
                    return Bt(t, $t);
                },
        },
        Ft = { f: Object.getOwnPropertySymbols },
        zt =
            C("Reflect", "ownKeys") ||
            function (t) {
                var e = Dt.f(it(t)),
                    n = Ft.f;
                return n ? e.concat(n(t)) : e;
            },
        Wt = function (t, e) {
            for (var n = zt(e), i = rt.f, o = nt.f, r = 0; r < n.length; r++) {
                var l = n[r];
                $(t, l) || i(t, l, o(e, l));
            }
        },
        Vt = /#|\.prototype\./,
        Ut = function (t, e) {
            var n = Yt[Gt(t)];
            return n == Xt || (n != Kt && ("function" == typeof e ? u(e) : !!e));
        },
        Gt = (Ut.normalize = function (t) {
            return String(t).replace(Vt, ".").toLowerCase();
        }),
        Yt = (Ut.data = {}),
        Kt = (Ut.NATIVE = "N"),
        Xt = (Ut.POLYFILL = "P"),
        Jt = Ut,
        Qt = nt.f,
        Zt = function (t, e) {
            var n,
                i,
                o,
                r,
                l,
                a = t.target,
                s = t.global,
                u = t.stat;
            if ((n = s ? c : u ? c[a] || L(a, {}) : (c[a] || {}).prototype))
                for (i in e) {
                    if (((r = e[i]), (o = t.noTargetGet ? (l = Qt(n, i)) && l.value : n[i]), !Jt(s ? i : a + (u ? "." : "#") + i, t.forced) && void 0 !== o)) {
                        if (typeof r == typeof o) continue;
                        Wt(r, o);
                    }
                    (t.sham || (o && o.sham)) && lt(r, "sham", !0), Et(n, i, r, t);
                }
        },
        te = function (t) {
            if (P(t)) throw TypeError("Cannot convert a Symbol value to a string");
            return String(t);
        },
        ee = function () {
            var t = it(this),
                e = "";
            return t.global && (e += "g"), t.ignoreCase && (e += "i"), t.multiline && (e += "m"), t.dotAll && (e += "s"), t.unicode && (e += "u"), t.sticky && (e += "y"), e;
        },
        ne = function (t, e) {
            return RegExp(t, e);
        },
        ie = {
            UNSUPPORTED_Y: u(function () {
                var t = ne("a", "y");
                return (t.lastIndex = 2), null != t.exec("abcd");
            }),
            BROKEN_CARET: u(function () {
                var t = ne("^r", "gy");
                return (t.lastIndex = 2), null != t.exec("str");
            }),
        },
        oe =
            Object.keys ||
            function (t) {
                return Bt(t, Ht);
            },
        re = h
            ? Object.defineProperties
            : function (t, e) {
                it(t);
                for (var n, i = oe(e), o = i.length, r = 0; o > r; ) rt.f(t, (n = i[r++]), e[n]);
                return t;
            },
        le = C("document", "documentElement"),
        ae = gt("IE_PROTO"),
        se = function () {},
        ce = function (t) {
            return "<script>" + t + "</" + "script>";
        },
        ue = function (t) {
            t.write(ce("")), t.close();
            var e = t.parentWindow.Object;
            return (t = null), e;
        },
        he = function () {
            try {
                Ct = new ActiveXObject("htmlfile");
            } catch (t) {}
            he =
                document.domain && Ct
                    ? ue(Ct)
                    : (function () {
                    var t,
                        e = Z("iframe");
                    if (e.style) return (e.style.display = "none"), le.appendChild(e), (e.src = String("javascript:")), (t = e.contentWindow.document).open(), t.write(ce("document.F=Object")), t.close(), t.F;
                })() || ue(Ct);
            for (var t = Ht.length; t--; ) delete he.prototype[Ht[t]];
            return he();
        };
    vt[ae] = !0;
    var fe,
        pe,
        de =
            Object.create ||
            function (t, e) {
                var n;
                return null !== t ? ((se.prototype = it(t)), (n = new se()), (se.prototype = null), (n[ae] = t)) : (n = he()), void 0 === e ? n : re(n, e);
            },
        ge = u(function () {
            var t = RegExp(".", "string".charAt(0));
            return !(t.dotAll && t.exec("\n") && "s" === t.flags);
        }),
        ve = u(function () {
            var t = RegExp("(?<a>b)", "string".charAt(5));
            return "b" !== t.exec("b").groups.a || "bc" !== "b".replace(t, "$<a>c");
        }),
        me = St.get,
        be = RegExp.prototype.exec,
        ye = M("native-string-replace", String.prototype.replace),
        we = be,
        _e = ((fe = /a/), (pe = /b*/g), be.call(fe, "a"), be.call(pe, "a"), 0 !== fe.lastIndex || 0 !== pe.lastIndex),
        xe = ie.UNSUPPORTED_Y || ie.BROKEN_CARET,
        je = void 0 !== /()??/.exec("")[1];
    (_e || je || xe || ge || ve) &&
    (we = function (t) {
        var e,
            n,
            i,
            o,
            r,
            l,
            a,
            s = this,
            c = me(s),
            u = te(t),
            h = c.raw;
        if (h) return (h.lastIndex = s.lastIndex), (e = we.call(h, u)), (s.lastIndex = h.lastIndex), e;
        var f = c.groups,
            p = xe && s.sticky,
            d = ee.call(s),
            g = s.source,
            v = 0,
            m = u;
        if (
            (p &&
            (-1 === (d = d.replace("y", "")).indexOf("g") && (d += "g"),
                (m = u.slice(s.lastIndex)),
            s.lastIndex > 0 && (!s.multiline || (s.multiline && "\n" !== u.charAt(s.lastIndex - 1))) && ((g = "(?: " + g + ")"), (m = " " + m), v++),
                (n = new RegExp("^(?:" + g + ")", d))),
            je && (n = new RegExp("^" + g + "$(?!\\s)", d)),
            _e && (i = s.lastIndex),
                (o = be.call(p ? n : s, m)),
                p ? (o ? ((o.input = o.input.slice(v)), (o[0] = o[0].slice(v)), (o.index = s.lastIndex), (s.lastIndex += o[0].length)) : (s.lastIndex = 0)) : _e && o && (s.lastIndex = s.global ? o.index + o[0].length : i),
            je &&
            o &&
            o.length > 1 &&
            ye.call(o[0], n, function () {
                for (r = 1; r < arguments.length - 2; r++) void 0 === arguments[r] && (o[r] = void 0);
            }),
            o && f)
        )
            for (o.groups = l = de(null), r = 0; r < f.length; r++) l[(a = f[r])[0]] = o[a[1]];
        return o;
    });
    var Ce = we;
    Zt({ target: "RegExp", proto: !0, forced: /./.exec !== Ce }, { exec: Ce });
    var Se = G("species"),
        Ee = RegExp.prototype,
        Ae = function (t, e, n, i) {
            var o = G(t),
                r = !u(function () {
                    var e = {};
                    return (
                        (e[o] = function () {
                            return 7;
                        }),
                        7 != ""[t](e)
                    );
                }),
                l =
                    r &&
                    !u(function () {
                        var e = !1,
                            n = /a/;
                        return (
                            "split" === t &&
                            (((n = {}).constructor = {}),
                                (n.constructor[Se] = function () {
                                    return n;
                                }),
                                (n.flags = ""),
                                (n[o] = /./[o])),
                                (n.exec = function () {
                                    return (e = !0), null;
                                }),
                                n[o](""),
                                !e
                        );
                    });
            if (!r || !l || n) {
                var a = /./[o],
                    s = e(o, ""[t], function (t, e, n, i, o) {
                        var l = e.exec;
                        return l === Ce || l === Ee.exec ? (r && !o ? { done: !0, value: a.call(e, n, i) } : { done: !0, value: t.call(n, e, i) }) : { done: !1 };
                    });
                Et(String.prototype, t, s[0]), Et(Ee, o, s[1]);
            }
            i && lt(Ee[o], "sham", !0);
        },
        ke = function (t) {
            return function (e, n) {
                var i,
                    o,
                    r = te(w(e)),
                    l = Tt(n),
                    a = r.length;
                return l < 0 || l >= a
                    ? t
                        ? ""
                        : void 0
                    : (i = r.charCodeAt(l)) < 55296 || i > 56319 || l + 1 === a || (o = r.charCodeAt(l + 1)) < 56320 || o > 57343
                        ? t
                            ? r.charAt(l)
                            : i
                        : t
                            ? r.slice(l, l + 2)
                            : o - 56320 + ((i - 55296) << 10) + 65536;
            };
        },
        Te = { codeAt: ke(!1), charAt: ke(!0) }.charAt,
        Ne = function (t, e, n) {
            return e + (n ? Te(t, e).length : 1);
        },
        Ie = function (t, e) {
            var n = t.exec;
            if ("function" == typeof n) {
                var i = n.call(t, e);
                if ("object" != typeof i) throw TypeError("RegExp exec method returned something other than an Object or null");
                return i;
            }
            if ("RegExp" !== m(t)) throw TypeError("RegExp#exec called on incompatible receiver");
            return Ce.call(t, e);
        };
    Ae("match", function (t, e, n) {
        return [
            function (e) {
                var n = w(this),
                    i = null == e ? void 0 : e[t];
                return void 0 !== i ? i.call(e, n) : new RegExp(e)[t](te(n));
            },
            function (t) {
                var i = it(this),
                    o = te(t),
                    r = n(e, i, o);
                if (r.done) return r.value;
                if (!i.global) return Ie(i, o);
                var l = i.unicode;
                i.lastIndex = 0;
                for (var a, s = [], c = 0; null !== (a = Ie(i, o)); ) {
                    var u = te(a[0]);
                    (s[c] = u), "" === u && (i.lastIndex = Ne(o, It(i.lastIndex), l)), c++;
                }
                return 0 === c ? null : s;
            },
        ];
    });
    var Oe =
            Array.isArray ||
            function (t) {
                return "Array" == m(t);
            },
        Pe = function (t, e, n) {
            var i = X(e);
            i in t ? rt.f(t, i, g(0, n)) : (t[i] = n);
        },
        Le = G("species"),
        qe = function (t, e) {
            return new ((function (t) {
                var e;
                return Oe(t) && ("function" != typeof (e = t.constructor) || (e !== Array && !Oe(e.prototype)) ? x(e) && null === (e = e[Le]) && (e = void 0) : (e = void 0)), void 0 === e ? Array : e;
            })(t))(0 === e ? 0 : e);
        },
        Re = G("species"),
        Me = function (t) {
            return (
                N >= 51 ||
                !u(function () {
                    var e = [];
                    return (
                        ((e.constructor = {})[Re] = function () {
                            return { foo: 1 };
                        }),
                        1 !== e[t](Boolean).foo
                    );
                })
            );
        },
        Be = G("isConcatSpreadable"),
        He = 9007199254740991,
        $e = "Maximum allowed index exceeded",
        De =
            N >= 51 ||
            !u(function () {
                var t = [];
                return (t[Be] = !1), t.concat()[0] !== t;
            }),
        Fe = Me("concat"),
        ze = function (t) {
            if (!x(t)) return !1;
            var e = t[Be];
            return void 0 !== e ? !!e : Oe(t);
        };
    Zt(
        { target: "Array", proto: !0, forced: !De || !Fe },
        {
            concat: function (t) {
                var e,
                    n,
                    i,
                    o,
                    r,
                    l = B(this),
                    a = qe(l, 0),
                    s = 0;
                for (e = -1, i = arguments.length; e < i; e++)
                    if (ze((r = -1 === e ? l : arguments[e]))) {
                        if (s + (o = It(r.length)) > He) throw TypeError($e);
                        for (n = 0; n < o; n++, s++) n in r && Pe(a, s, r[n]);
                    } else {
                        if (s >= He) throw TypeError($e);
                        Pe(a, s++, r);
                    }
                return (a.length = s), a;
            },
        }
    );
    var We = {};
    We[G("toStringTag")] = "z";
    var Ve = "[object z]" === String(We),
        Ue = G("toStringTag"),
        Ge =
            "Arguments" ==
            m(
                (function () {
                    return arguments;
                })()
            ),
        Ye = Ve
            ? m
            : function (t) {
                var e, n, i;
                return void 0 === t
                    ? "Undefined"
                    : null === t
                        ? "Null"
                        : "string" ==
                        typeof (n = (function (t, e) {
                            try {
                                return t[e];
                            } catch (t) {}
                        })((e = Object(t)), Ue))
                            ? n
                            : Ge
                                ? m(e)
                                : "Object" == (i = m(e)) && "function" == typeof e.callee
                                    ? "Arguments"
                                    : i;
            },
        Ke = Ve
            ? {}.toString
            : function () {
                return "[object " + Ye(this) + "]";
            };
    Ve || Et(Object.prototype, "toString", Ke, { unsafe: !0 });
    var Xe = "toString",
        Je = RegExp.prototype,
        Qe = Je.toString,
        Ze = u(function () {
            return "/a/b" != Qe.call({ source: "a", flags: "b" });
        }),
        tn = Qe.name != Xe;
    (Ze || tn) &&
    Et(
        RegExp.prototype,
        Xe,
        function () {
            var t = it(this),
                e = te(t.source),
                n = t.flags;
            return "/" + e + "/" + te(void 0 === n && t instanceof RegExp && !("flags" in Je) ? ee.call(t) : n);
        },
        { unsafe: !0 }
    );
    var en = G("match"),
        nn = function (t) {
            var e;
            return x(t) && (void 0 !== (e = t[en]) ? !!e : "RegExp" == m(t));
        },
        on = function (t) {
            if ("function" != typeof t) throw TypeError(String(t) + " is not a function");
            return t;
        },
        rn = G("species"),
        ln = ie.UNSUPPORTED_Y,
        an = [].push,
        sn = Math.min,
        cn = 4294967295;
    function un(t, e) {
        if (t instanceof SVGElement) {
            var i = t.getAttribute("class") || "";
            i.match(e) || t.setAttribute("class", "".concat(i, " ").concat(e));
        } else {
            if (void 0 !== t.classList)
                n(e.split(" "), function (e) {
                    t.classList.add(e);
                });
            else t.className.match(e) || (t.className += " ".concat(e));
        }
    }
    function hn(t, e) {
        var n = "";
        return t.currentStyle ? (n = t.currentStyle[e]) : document.defaultView && document.defaultView.getComputedStyle && (n = document.defaultView.getComputedStyle(t, null).getPropertyValue(e)), n && n.toLowerCase ? n.toLowerCase() : n;
    }
    function fn(t) {
        var e = t.element;
        if (this._options.scrollToElement) {
            var n = (function (t) {
                var e = window.getComputedStyle(t),
                    n = "absolute" === e.position,
                    i = /(auto|scroll)/;
                if ("fixed" === e.position) return document.body;
                for (var o = t; (o = o.parentElement); ) if (((e = window.getComputedStyle(o)), (!n || "static" !== e.position) && i.test(e.overflow + e.overflowY + e.overflowX))) return o;
                return document.body;
            })(e);
            n !== document.body && (n.scrollTop = e.offsetTop - n.offsetTop);
        }
    }
    function pn() {
        if (void 0 !== window.innerWidth) return { width: window.innerWidth, height: window.innerHeight };
        var t = document.documentElement;
        return { width: t.clientWidth, height: t.clientHeight };
    }
    function dn(t, e, n) {
        var i,
            o = e.element;
        if (
            "off" !== t &&
            this._options.scrollToElement &&
            ((i = "tooltip" === t ? n.getBoundingClientRect() : o.getBoundingClientRect()),
                !(function (t) {
                    var e = t.getBoundingClientRect();
                    return e.top >= 0 && e.left >= 0 && e.bottom + 80 <= window.innerHeight && e.right <= window.innerWidth;
                })(o))
        ) {
            var r = pn().height;
            i.bottom - (i.bottom - i.top) < 0 || o.clientHeight > r ? window.scrollBy(0, i.top - (r / 2 - i.height / 2) - this._options.scrollPadding) : window.scrollBy(0, i.top - (r / 2 - i.height / 2) + this._options.scrollPadding);
        }
    }
    function gn(t) {
        t.setAttribute("role", "button"), (t.tabIndex = 0);
    }
    Ae(
        "split",
        function (t, e, n) {
            var i;
            return (
                (i =
                    "c" == "abbc".split(/(b)*/)[1] || 4 != "test".split(/(?:)/, -1).length || 2 != "ab".split(/(?:ab)*/).length || 4 != ".".split(/(.?)(.?)/).length || ".".split(/()()/).length > 1 || "".split(/.?/).length
                        ? function (t, n) {
                            var i = te(w(this)),
                                o = void 0 === n ? cn : n >>> 0;
                            if (0 === o) return [];
                            if (void 0 === t) return [i];
                            if (!nn(t)) return e.call(i, t, o);
                            for (
                                var r, l, a, s = [], c = (t.ignoreCase ? "i" : "") + (t.multiline ? "m" : "") + (t.unicode ? "u" : "") + (t.sticky ? "y" : ""), u = 0, h = new RegExp(t.source, c + "g");
                                (r = Ce.call(h, i)) && !((l = h.lastIndex) > u && (s.push(i.slice(u, r.index)), r.length > 1 && r.index < i.length && an.apply(s, r.slice(1)), (a = r[0].length), (u = l), s.length >= o));

                            )
                                h.lastIndex === r.index && h.lastIndex++;
                            return u === i.length ? (!a && h.test("")) || s.push("") : s.push(i.slice(u)), s.length > o ? s.slice(0, o) : s;
                        }
                        : "0".split(void 0, 0).length
                            ? function (t, n) {
                                return void 0 === t && 0 === n ? [] : e.call(this, t, n);
                            }
                            : e),
                    [
                        function (e, n) {
                            var o = w(this),
                                r = null == e ? void 0 : e[t];
                            return void 0 !== r ? r.call(e, o, n) : i.call(te(o), e, n);
                        },
                        function (t, o) {
                            var r = it(this),
                                l = te(t),
                                a = n(i, r, l, o, i !== e);
                            if (a.done) return a.value;
                            var s = (function (t, e) {
                                    var n,
                                        i = it(t).constructor;
                                    return void 0 === i || null == (n = it(i)[rn]) ? e : on(n);
                                })(r, RegExp),
                                c = r.unicode,
                                u = (r.ignoreCase ? "i" : "") + (r.multiline ? "m" : "") + (r.unicode ? "u" : "") + (ln ? "g" : "y"),
                                h = new s(ln ? "^(?:" + r.source + ")" : r, u),
                                f = void 0 === o ? cn : o >>> 0;
                            if (0 === f) return [];
                            if (0 === l.length) return null === Ie(h, l) ? [l] : [];
                            for (var p = 0, d = 0, g = []; d < l.length; ) {
                                h.lastIndex = ln ? 0 : d;
                                var v,
                                    m = Ie(h, ln ? l.slice(d) : l);
                                if (null === m || (v = sn(It(h.lastIndex + (ln ? d : 0)), l.length)) === p) d = Ne(l, d, c);
                                else {
                                    if ((g.push(l.slice(p, d)), g.length === f)) return g;
                                    for (var b = 1; b <= m.length - 1; b++) if ((g.push(m[b]), g.length === f)) return g;
                                    d = p = v;
                                }
                            }
                            return g.push(l.slice(p)), g;
                        },
                    ]
            );
        },
        !!u(function () {
            var t = /(?:)/,
                e = t.exec;
            t.exec = function () {
                return e.apply(this, arguments);
            };
            var n = "ab".split(t);
            return 2 !== n.length || "a" !== n[0] || "b" !== n[1];
        }),
        ln
    );
    var vn = Object.assign,
        mn = Object.defineProperty,
        bn =
            !vn ||
            u(function () {
                if (
                    h &&
                    1 !==
                    vn(
                        { b: 1 },
                        vn(
                            mn({}, "a", {
                                enumerable: !0,
                                get: function () {
                                    mn(this, "b", { value: 3, enumerable: !1 });
                                },
                            }),
                            { b: 2 }
                        )
                    ).b
                )
                    return !0;
                var t = {},
                    e = {},
                    n = Symbol(),
                    i = "abcdefghijklmnopqrst";
                return (
                    (t[n] = 7),
                        i.split("").forEach(function (t) {
                            e[t] = t;
                        }),
                    7 != vn({}, t)[n] || oe(vn({}, e)).join("") != i
                );
            })
                ? function (t, e) {
                    for (var n = B(t), i = arguments.length, o = 1, r = Ft.f, l = d.f; i > o; )
                        for (var a, s = y(arguments[o++]), c = r ? oe(s).concat(r(s)) : oe(s), u = c.length, f = 0; u > f; ) (a = c[f++]), (h && !l.call(s, a)) || (n[a] = s[a]);
                    return n;
                }
                : vn;
    function yn(t) {
        var e = t.parentNode;
        return !(!e || "HTML" === e.nodeName) && ("fixed" === hn(t, "position") || yn(e));
    }
    function wn(t, e) {
        var n = document.body,
            i = document.documentElement,
            o = window.pageYOffset || i.scrollTop || n.scrollTop,
            r = window.pageXOffset || i.scrollLeft || n.scrollLeft;
        e = e || n;
        var l = t.getBoundingClientRect(),
            a = e.getBoundingClientRect(),
            s = hn(e, "position"),
            c = { width: l.width, height: l.height };
        return ("body" !== e.tagName.toLowerCase() && "relative" === s) || "sticky" === s
            ? Object.assign(c, { top: l.top - a.top, left: l.left - a.left })
            : yn(t)
                ? Object.assign(c, { top: l.top, left: l.left })
                : Object.assign(c, { top: l.top + o, left: l.left + r });
    }
    Zt({ target: "Object", stat: !0, forced: Object.assign !== bn }, { assign: bn });
    var _n = Math.floor,
        xn = "".replace,
        jn = /\$([$&'`]|\d{1,2}|<[^>]*>)/g,
        Cn = /\$([$&'`]|\d{1,2})/g,
        Sn = function (t, e, n, i, o, r) {
            var l = n + t.length,
                a = i.length,
                s = Cn;
            return (
                void 0 !== o && ((o = B(o)), (s = jn)),
                    xn.call(r, s, function (r, s) {
                        var c;
                        switch (s.charAt(0)) {
                            case "$":
                                return "$";
                            case "&":
                                return t;
                            case "`":
                                return e.slice(0, n);
                            case "'":
                                return e.slice(l);
                            case "<":
                                c = o[s.slice(1, -1)];
                                break;
                            default:
                                var u = +s;
                                if (0 === u) return r;
                                if (u > a) {
                                    var h = _n(u / 10);
                                    return 0 === h ? r : h <= a ? (void 0 === i[h - 1] ? s.charAt(1) : i[h - 1] + s.charAt(1)) : r;
                                }
                                c = i[u - 1];
                        }
                        return void 0 === c ? "" : c;
                    })
            );
        },
        En = G("replace"),
        An = Math.max,
        kn = Math.min,
        Tn = "$0" === "a".replace(/./, "$0"),
        Nn = !!/./[En] && "" === /./[En]("a", "$0");
    function In(t, e) {
        if (t instanceof SVGElement) {
            var n = t.getAttribute("class") || "";
            t.setAttribute("class", n.replace(e, "").replace(/^\s+|\s+$/g, ""));
        } else t.className = t.className.replace(e, "").replace(/^\s+|\s+$/g, "");
    }
    function On(t, e) {
        var n = "";
        if ((t.style.cssText && (n += t.style.cssText), "string" == typeof e)) n += e;
        else for (var i in e) n += "".concat(i, ":").concat(e[i], ";");
        t.style.cssText = n;
    }
    function Pn(t) {
        if (t) {
            if (!this._introItems[this._currentStep]) return;
            var e = this._introItems[this._currentStep],
                n = wn(e.element, this._targetElement),
                i = this._options.helperElementPadding;
            yn(e.element) ? un(t, "introjs-fixedTooltip") : In(t, "introjs-fixedTooltip"),
            "floating" === e.position && (i = 0),
                On(t, { width: "".concat(n.width + i, "px"), height: "".concat(n.height + i, "px"), top: "".concat(n.top - i / 2, "px"), left: "".concat(n.left - i / 2, "px") });
        }
    }
    Ae(
        "replace",
        function (t, e, n) {
            var i = Nn ? "$" : "$0";
            return [
                function (t, n) {
                    var i = w(this),
                        o = null == t ? void 0 : t[En];
                    return void 0 !== o ? o.call(t, i, n) : e.call(te(i), t, n);
                },
                function (t, o) {
                    var r = it(this),
                        l = te(t);
                    if ("string" == typeof o && -1 === o.indexOf(i) && -1 === o.indexOf("$<")) {
                        var a = n(e, r, l, o);
                        if (a.done) return a.value;
                    }
                    var s = "function" == typeof o;
                    s || (o = te(o));
                    var c = r.global;
                    if (c) {
                        var u = r.unicode;
                        r.lastIndex = 0;
                    }
                    for (var h = []; ; ) {
                        var f = Ie(r, l);
                        if (null === f) break;
                        if ((h.push(f), !c)) break;
                        "" === te(f[0]) && (r.lastIndex = Ne(l, It(r.lastIndex), u));
                    }
                    for (var p, d = "", g = 0, v = 0; v < h.length; v++) {
                        f = h[v];
                        for (var m = te(f[0]), b = An(kn(Tt(f.index), l.length), 0), y = [], w = 1; w < f.length; w++) y.push(void 0 === (p = f[w]) ? p : String(p));
                        var _ = f.groups;
                        if (s) {
                            var x = [m].concat(y, b, l);
                            void 0 !== _ && x.push(_);
                            var j = te(o.apply(void 0, x));
                        } else j = Sn(m, l, b, y, _, o);
                        b >= g && ((d += l.slice(g, b) + j), (g = b + m.length));
                    }
                    return d + l.slice(g);
                },
            ];
        },
        !!u(function () {
            var t = /./;
            return (
                (t.exec = function () {
                    var t = [];
                    return (t.groups = { a: "7" }), t;
                }),
                "7" !== "".replace(t, "$<a>")
            );
        }) ||
        !Tn ||
        Nn
    );
    var Ln = G("unscopables"),
        qn = Array.prototype;
    null == qn[Ln] && rt.f(qn, Ln, { configurable: !0, value: de(null) });
    var Rn,
        Mn = Rt.includes;
    Zt(
        { target: "Array", proto: !0 },
        {
            includes: function (t) {
                return Mn(this, t, arguments.length > 1 ? arguments[1] : void 0);
            },
        }
    ),
        (Rn = "includes"),
        (qn[Ln][Rn] = !0);
    var Bn = Me("slice"),
        Hn = G("species"),
        $n = [].slice,
        Dn = Math.max;
    Zt(
        { target: "Array", proto: !0, forced: !Bn },
        {
            slice: function (t, e) {
                var n,
                    i,
                    o,
                    r = _(this),
                    l = It(r.length),
                    a = Lt(t, l),
                    s = Lt(void 0 === e ? l : e, l);
                if (Oe(r) && ("function" != typeof (n = r.constructor) || (n !== Array && !Oe(n.prototype)) ? x(n) && null === (n = n[Hn]) && (n = void 0) : (n = void 0), n === Array || void 0 === n)) return $n.call(r, a, s);
                for (i = new (void 0 === n ? Array : n)(Dn(s - a, 0)), o = 0; a < s; a++, o++) a in r && Pe(i, o, r[a]);
                return (i.length = o), i;
            },
        }
    );
    var Fn = function (t) {
            if (nn(t)) throw TypeError("The method doesn't accept regular expressions");
            return t;
        },
        zn = G("match");
    Zt(
        {
            target: "String",
            proto: !0,
            forced: !(function (t) {
                var e = /./;
                try {
                    "/./"[t](e);
                } catch (n) {
                    try {
                        return (e[zn] = !1), "/./"[t](e);
                    } catch (t) {}
                }
                return !1;
            })("includes"),
        },
        {
            includes: function (t) {
                return !!~te(w(this)).indexOf(te(Fn(t)), arguments.length > 1 ? arguments[1] : void 0);
            },
        }
    );
    var Wn = function (t, e) {
            var n = [][t];
            return (
                !!n &&
                u(function () {
                    n.call(
                        null,
                        e ||
                        function () {
                            throw 1;
                        },
                        1
                    );
                })
            );
        },
        Vn = [].join,
        Un = y != Object,
        Gn = Wn("join", ",");
    Zt(
        { target: "Array", proto: !0, forced: Un || !Gn },
        {
            join: function (t) {
                return Vn.call(_(this), void 0 === t ? "," : t);
            },
        }
    );
    var Yn = [].push,
        Kn = function (t) {
            var e = 1 == t,
                n = 2 == t,
                i = 3 == t,
                o = 4 == t,
                r = 6 == t,
                l = 7 == t,
                a = 5 == t || r;
            return function (s, c, u, h) {
                for (
                    var f,
                        p,
                        d = B(s),
                        g = y(d),
                        v = (function (t, e, n) {
                            if ((on(t), void 0 === e)) return t;
                            switch (n) {
                                case 0:
                                    return function () {
                                        return t.call(e);
                                    };
                                case 1:
                                    return function (n) {
                                        return t.call(e, n);
                                    };
                                case 2:
                                    return function (n, i) {
                                        return t.call(e, n, i);
                                    };
                                case 3:
                                    return function (n, i, o) {
                                        return t.call(e, n, i, o);
                                    };
                            }
                            return function () {
                                return t.apply(e, arguments);
                            };
                        })(c, u, 3),
                        m = It(g.length),
                        b = 0,
                        w = h || qe,
                        _ = e ? w(s, m) : n || l ? w(s, 0) : void 0;
                    m > b;
                    b++
                )
                    if ((a || b in g) && ((p = v((f = g[b]), b, d)), t))
                        if (e) _[b] = p;
                        else if (p)
                            switch (t) {
                                case 3:
                                    return !0;
                                case 5:
                                    return f;
                                case 6:
                                    return b;
                                case 2:
                                    Yn.call(_, f);
                            }
                        else
                            switch (t) {
                                case 4:
                                    return !1;
                                case 7:
                                    Yn.call(_, f);
                            }
                return r ? -1 : i || o ? o : _;
            };
        },
        Xn = { forEach: Kn(0), map: Kn(1), filter: Kn(2), some: Kn(3), every: Kn(4), find: Kn(5), findIndex: Kn(6), filterReject: Kn(7) }.filter;
    function Jn(t, e, n, i, o) {
        return t.left + e + n.width > i.width ? ((o.style.left = "".concat(i.width - n.width - t.left, "px")), !1) : ((o.style.left = "".concat(e, "px")), !0);
    }
    function Qn(t, e, n, i) {
        return t.left + t.width - e - n.width < 0 ? ((i.style.left = "".concat(-t.left, "px")), !1) : ((i.style.right = "".concat(e, "px")), !0);
    }
    Zt(
        { target: "Array", proto: !0, forced: !Me("filter") },
        {
            filter: function (t) {
                return Xn(this, t, arguments.length > 1 ? arguments[1] : void 0);
            },
        }
    );
    var Zn = Me("splice"),
        ti = Math.max,
        ei = Math.min,
        ni = 9007199254740991,
        ii = "Maximum allowed length exceeded";
    function oi(t, e) {
        t.includes(e) && t.splice(t.indexOf(e), 1);
    }
    function ri(t, e, n) {
        var i = this._options.positionPrecedence.slice(),
            o = pn(),
            r = wn(e).height + 10,
            l = wn(e).width + 20,
            a = t.getBoundingClientRect(),
            s = "floating";
        a.bottom + r > o.height && oi(i, "bottom"), a.top - r < 0 && oi(i, "top"), a.right + l > o.width && oi(i, "right"), a.left - l < 0 && oi(i, "left");
        var c,
            u,
            h = -1 !== (u = (c = n || "").indexOf("-")) ? c.substr(u) : "";
        return (
            n && (n = n.split("-")[0]),
            i.length && (s = i.includes(n) ? n : i[0]),
            ["top", "bottom"].includes(s) &&
            (s += (function (t, e, n, i) {
                var o = n.width,
                    r = e / 2,
                    l = Math.min(o, window.screen.width),
                    a = ["-left-aligned", "-middle-aligned", "-right-aligned"];
                return l - t < e && oi(a, "-left-aligned"), (t < r || l - t < r) && oi(a, "-middle-aligned"), t < e && oi(a, "-right-aligned"), a.length ? (a.includes(i) ? i : a[0]) : "-middle-aligned";
            })(a.left, l, o, h)),
                s
        );
    }
    function li(t, e, n, i) {
        var o,
            r,
            l,
            a,
            s,
            c = "";
        if (
            ((i = i || !1),
                (e.style.top = null),
                (e.style.right = null),
                (e.style.bottom = null),
                (e.style.left = null),
                (e.style.marginLeft = null),
                (e.style.marginTop = null),
                (n.style.display = "inherit"),
                this._introItems[this._currentStep])
        )
            switch (
                ((c = "string" == typeof (o = this._introItems[this._currentStep]).tooltipClass ? o.tooltipClass : this._options.tooltipClass),
                    (e.className = ["introjs-tooltip", c].filter(Boolean).join(" ")),
                    e.setAttribute("role", "dialog"),
                "floating" !== (s = this._introItems[this._currentStep].position) && this._options.autoPosition && (s = ri.call(this, t, e, s)),
                    (l = wn(t)),
                    (r = wn(e)),
                    (a = pn()),
                    un(e, "introjs-".concat(s)),
                    s)
                ) {
                case "top-right-aligned":
                    n.className = "introjs-arrow bottom-right";
                    var u = 0;
                    Qn(l, u, r, e), (e.style.bottom = "".concat(l.height + 20, "px"));
                    break;
                case "top-middle-aligned":
                    n.className = "introjs-arrow bottom-middle";
                    var h = l.width / 2 - r.width / 2;
                    i && (h += 5), Qn(l, h, r, e) && ((e.style.right = null), Jn(l, h, r, a, e)), (e.style.bottom = "".concat(l.height + 20, "px"));
                    break;
                case "top-left-aligned":
                case "top":
                    (n.className = "introjs-arrow bottom"), Jn(l, i ? 0 : 15, r, a, e), (e.style.bottom = "".concat(l.height + 20, "px"));
                    break;
                case "right":
                    (e.style.left = "".concat(l.width + 20, "px")),
                        l.top + r.height > a.height ? ((n.className = "introjs-arrow left-bottom"), (e.style.top = "-".concat(r.height - l.height - 20, "px"))) : (n.className = "introjs-arrow left");
                    break;
                case "left":
                    i || !0 !== this._options.showStepNumbers || (e.style.top = "15px"),
                        l.top + r.height > a.height ? ((e.style.top = "-".concat(r.height - l.height - 20, "px")), (n.className = "introjs-arrow right-bottom")) : (n.className = "introjs-arrow right"),
                        (e.style.right = "".concat(l.width + 20, "px"));
                    break;
                case "floating":
                    (n.style.display = "none"), (e.style.left = "50%"), (e.style.top = "50%"), (e.style.marginLeft = "-".concat(r.width / 2, "px")), (e.style.marginTop = "-".concat(r.height / 2, "px"));
                    break;
                case "bottom-right-aligned":
                    (n.className = "introjs-arrow top-right"), Qn(l, (u = 0), r, e), (e.style.top = "".concat(l.height + 20, "px"));
                    break;
                case "bottom-middle-aligned":
                    (n.className = "introjs-arrow top-middle"), (h = l.width / 2 - r.width / 2), i && (h += 5), Qn(l, h, r, e) && ((e.style.right = null), Jn(l, h, r, a, e)), (e.style.top = "".concat(l.height + 20, "px"));
                    break;
                default:
                    (n.className = "introjs-arrow top"), Jn(l, 0, r, a, e), (e.style.top = "".concat(l.height + 20, "px"));
            }
    }
    function ai() {
        n(document.querySelectorAll(".introjs-showElement"), function (t) {
            In(t, /introjs-[a-zA-Z]+/g);
        });
    }
    function si(t, e) {
        var n = document.createElement(t);
        e = e || {};
        var i = /^(?:role|data-|aria-)/;
        for (var o in e) {
            var r = e[o];
            "style" === o ? On(n, r) : o.match(i) ? n.setAttribute(o, r) : (n[o] = r);
        }
        return n;
    }
    function ci(t, e, n) {
        if (n) {
            var i = e.style.opacity || "1";
            On(e, { opacity: "0" }),
                window.setTimeout(function () {
                    On(e, { opacity: i });
                }, 10);
        }
        t.appendChild(e);
    }
    function ui() {
        return (parseInt(this._currentStep + 1, 10) / this._introItems.length) * 100;
    }
    function hi() {
        var t = document.querySelector(".introjs-disableInteraction");
        null === t && ((t = si("div", { className: "introjs-disableInteraction" })), this._targetElement.appendChild(t)), Pn.call(this, t);
    }
    function fi(t) {
        var e = this,
            i = si("div", { className: "introjs-bullets" });
        !1 === this._options.showBullets && (i.style.display = "none");
        var o = si("ul");
        o.setAttribute("role", "tablist");
        var r = function () {
            e.goToStep(this.getAttribute("data-stepnumber"));
        };
        return (
            n(this._introItems, function (e, n) {
                var i = e.step,
                    l = si("li"),
                    a = si("a");
                l.setAttribute("role", "presentation"),
                    a.setAttribute("role", "tab"),
                    (a.onclick = r),
                n === t.step - 1 && (a.className = "active"),
                    gn(a),
                    (a.innerHTML = "&nbsp;"),
                    a.setAttribute("data-stepnumber", i),
                    l.appendChild(a),
                    o.appendChild(l);
            }),
                i.appendChild(o),
                i
        );
    }
    function pi(t, e) {
        if (this._options.showBullets) {
            var n = document.querySelector(".introjs-bullets");
            n.parentNode.replaceChild(fi.call(this, e), n);
        }
    }
    function di(t, e) {
        this._options.showBullets && ((t.querySelector(".introjs-bullets li > a.active").className = ""), (t.querySelector('.introjs-bullets li > a[data-stepnumber="'.concat(e.step, '"]')).className = "active"));
    }
    function gi() {
        var t = si("div");
        (t.className = "introjs-progress"), !1 === this._options.showProgress && (t.style.display = "none");
        var e = si("div", { className: "introjs-progressbar" });
        return (
            this._options.progressBarAdditionalClass && (e.className += " " + this._options.progressBarAdditionalClass),
                e.setAttribute("role", "progress"),
                e.setAttribute("aria-valuemin", 0),
                e.setAttribute("aria-valuemax", 100),
                e.setAttribute("aria-valuenow", ui.call(this)),
                (e.style.cssText = "width:".concat(ui.call(this), "%;")),
                t.appendChild(e),
                t
        );
    }
    function vi(t) {
        (t.querySelector(".introjs-progress .introjs-progressbar").style.cssText = "width:".concat(ui.call(this), "%;")), t.querySelector(".introjs-progress .introjs-progressbar").setAttribute("aria-valuenow", ui.call(this));
    }
    function mi(t) {
        var e = this;
        void 0 !== this._introChangeCallback && this._introChangeCallback.call(this, t.element);
        var n,
            i,
            o,
            r = this,
            l = document.querySelector(".introjs-helperLayer"),
            a = document.querySelector(".introjs-tooltipReferenceLayer"),
            s = "introjs-helperLayer";
        if (("string" == typeof t.highlightClass && (s += " ".concat(t.highlightClass)), "string" == typeof this._options.highlightClass && (s += " ".concat(this._options.highlightClass)), null !== l && null !== a)) {
            var c = a.querySelector(".introjs-helperNumberLayer"),
                u = a.querySelector(".introjs-tooltiptext"),
                h = a.querySelector(".introjs-tooltip-title"),
                f = a.querySelector(".introjs-arrow"),
                p = a.querySelector(".introjs-tooltip");
            (o = a.querySelector(".introjs-skipbutton")),
                (i = a.querySelector(".introjs-prevbutton")),
                (n = a.querySelector(".introjs-nextbutton")),
                (l.className = s),
                (p.style.opacity = 0),
                (p.style.display = "none"),
                fn.call(r, t),
                Pn.call(r, l),
                Pn.call(r, a),
                ai(),
            r._lastShowElementTimer && window.clearTimeout(r._lastShowElementTimer),
                (r._lastShowElementTimer = window.setTimeout(function () {
                    null !== c && (c.innerHTML = "".concat(t.step, " of ").concat(e._introItems.length)),
                        (u.innerHTML = t.intro),
                        (h.innerHTML = t.title),
                        (p.style.display = "block"),
                        li.call(r, t.element, p, f),
                        di.call(r, a, t),
                        vi.call(r, a),
                        (p.style.opacity = 1),
                    ((null != n && /introjs-donebutton/gi.test(n.className)) || null != n) && n.focus(),
                        dn.call(r, t.scrollTo, t, u);
                }, 350));
        } else {
            var d = si("div", { className: s }),
                g = si("div", { className: "introjs-tooltipReferenceLayer" }),
                v = si("div", { className: "introjs-arrow" }),
                m = si("div", { className: "introjs-tooltip" }),
                b = si("div", { className: "introjs-tooltiptext" }),
                y = si("div", { className: "introjs-tooltip-header" }),
                w = si("h1", { className: "introjs-tooltip-title" }),
                _ = si("div");
            On(d, { "box-shadow": "0 0 1px 2px rgba(33, 33, 33, 0.8), rgba(33, 33, 33, ".concat(r._options.overlayOpacity.toString(), ") 0 0 0 5000px") }),
                fn.call(r, t),
                Pn.call(r, d),
                Pn.call(r, g),
                ci(this._targetElement, d, !0),
                ci(this._targetElement, g),
                (b.innerHTML = t.intro),
                (w.innerHTML = t.title),
                (_.className = "introjs-tooltipbuttons"),
            !1 === this._options.showButtons && (_.style.display = "none"),
                y.appendChild(w),
                m.appendChild(y),
                m.appendChild(b),
                m.appendChild(fi.call(this, t)),
                m.appendChild(gi.call(this));
            var x = si("div");
            !0 === this._options.showStepNumbers && ((x.className = "introjs-helperNumberLayer"), (x.innerHTML = "".concat(t.step, " of ").concat(this._introItems.length)), m.appendChild(x)),
                m.appendChild(v),
                g.appendChild(m),
                ((n = si("a")).onclick = function () {
                    r._introItems.length - 1 !== r._currentStep ? wi.call(r) : /introjs-donebutton/gi.test(n.className) && ("function" == typeof r._introCompleteCallback && r._introCompleteCallback.call(r), oo.call(r, r._targetElement));
                }),
                gn(n),
                (n.innerHTML = this._options.nextLabel),
                ((i = si("a")).onclick = function () {
                    0 !== r._currentStep && _i.call(r);
                }),
                gn(i),
                (i.innerHTML = this._options.prevLabel),
                gn((o = si("a", { className: "introjs-skipbutton" }))),
                (o.innerHTML = this._options.skipLabel),
                (o.onclick = function () {
                    r._introItems.length - 1 === r._currentStep && "function" == typeof r._introCompleteCallback && r._introCompleteCallback.call(r),
                    "function" == typeof r._introSkipCallback && r._introSkipCallback.call(r),
                        oo.call(r, r._targetElement);
                }),
                y.appendChild(o),
            this._introItems.length > 1 && _.appendChild(i),
                _.appendChild(n),
                m.appendChild(_),
                li.call(r, t.element, m, v),
                dn.call(this, t.scrollTo, t, m);
        }
        var j = r._targetElement.querySelector(".introjs-disableInteraction");
        j && j.parentNode.removeChild(j),
        t.disableInteraction && hi.call(r),
            0 === this._currentStep && this._introItems.length > 1
                ? (null != n && ((n.className = "".concat(this._options.buttonClass, " introjs-nextbutton")), (n.innerHTML = this._options.nextLabel)),
                    !0 === this._options.hidePrev
                        ? (null != i && (i.className = "".concat(this._options.buttonClass, " introjs-prevbutton introjs-hidden")), null != n && un(n, "introjs-fullbutton"))
                        : null != i && (i.className = "".concat(this._options.buttonClass, " introjs-prevbutton introjs-disabled")))
                : this._introItems.length - 1 === this._currentStep || 1 === this._introItems.length
                    ? (null != i && (i.className = "".concat(this._options.buttonClass, " introjs-prevbutton")),
                        !0 === this._options.hideNext
                            ? (null != n && (n.className = "".concat(this._options.buttonClass, " introjs-nextbutton introjs-hidden")), null != i && un(i, "introjs-fullbutton"))
                            : null != n &&
                            (!0 === this._options.nextToDone
                                ? ((n.innerHTML = this._options.doneLabel), un(n, "".concat(this._options.buttonClass, " introjs-nextbutton introjs-donebutton")))
                                : (n.className = "".concat(this._options.buttonClass, " introjs-nextbutton introjs-disabled"))))
                    : (null != i && (i.className = "".concat(this._options.buttonClass, " introjs-prevbutton")),
                    null != n && ((n.className = "".concat(this._options.buttonClass, " introjs-nextbutton")), (n.innerHTML = this._options.nextLabel))),
        null != i && i.setAttribute("role", "button"),
        null != n && n.setAttribute("role", "button"),
        null != o && o.setAttribute("role", "button"),
        null != n && n.focus(),
            (function (t) {
                var e = t.element;
                un(e, "introjs-showElement");
                var n = hn(e, "position");
                "absolute" !== n && "relative" !== n && "sticky" !== n && "fixed" !== n && un(e, "introjs-relativePosition");
            })(t),
        void 0 !== this._introAfterChangeCallback && this._introAfterChangeCallback.call(this, t.element);
    }
    function bi(t) {
        (this._currentStep = t - 2), void 0 !== this._introItems && wi.call(this);
    }
    function yi(t) {
        (this._currentStepNumber = t), void 0 !== this._introItems && wi.call(this);
    }
    function wi() {
        var t = this;
        (this._direction = "forward"),
        void 0 !== this._currentStepNumber &&
        n(this._introItems, function (e, n) {
            e.step === t._currentStepNumber && ((t._currentStep = n - 1), (t._currentStepNumber = void 0));
        }),
            void 0 === this._currentStep ? (this._currentStep = 0) : ++this._currentStep;
        var e = this._introItems[this._currentStep],
            i = !0;
        return (
            void 0 !== this._introBeforeChangeCallback && (i = this._introBeforeChangeCallback.call(this, e && e.element)),
                !1 === i
                    ? (--this._currentStep, !1)
                    : this._introItems.length <= this._currentStep
                        ? ("function" == typeof this._introCompleteCallback && this._introCompleteCallback.call(this), void oo.call(this, this._targetElement))
                        : void mi.call(this, e)
        );
    }
    function _i() {
        if (((this._direction = "backward"), 0 === this._currentStep)) return !1;
        --this._currentStep;
        var t = this._introItems[this._currentStep],
            e = !0;
        if ((void 0 !== this._introBeforeChangeCallback && (e = this._introBeforeChangeCallback.call(this, t && t.element)), !1 === e)) return ++this._currentStep, !1;
        mi.call(this, t);
    }
    function xi() {
        return this._currentStep;
    }
    function ji(t) {
        var e = void 0 === t.code ? t.which : t.code;
        if ((null === e && (e = null === t.charCode ? t.keyCode : t.charCode), ("Escape" !== e && 27 !== e) || !0 !== this._options.exitOnEsc)) {
            if ("ArrowLeft" === e || 37 === e) _i.call(this);
            else if ("ArrowRight" === e || 39 === e) wi.call(this);
            else if ("Enter" === e || "NumpadEnter" === e || 13 === e) {
                var n = t.target || t.srcElement;
                n && n.className.match("introjs-prevbutton")
                    ? _i.call(this)
                    : n && n.className.match("introjs-skipbutton")
                        ? (this._introItems.length - 1 === this._currentStep && "function" == typeof this._introCompleteCallback && this._introCompleteCallback.call(this), oo.call(this, this._targetElement))
                        : n && n.getAttribute("data-stepnumber")
                            ? n.click()
                            : wi.call(this),
                    t.preventDefault ? t.preventDefault() : (t.returnValue = !1);
            }
        } else oo.call(this, this._targetElement);
    }
    function Ci(e) {
        if (null === e || "object" !== t(e) || void 0 !== e.nodeType) return e;
        var n = {};
        for (var i in e) void 0 !== window.jQuery && e[i] instanceof window.jQuery ? (n[i] = e[i]) : (n[i] = Ci(e[i]));
        return n;
    }
    function Si(t) {
        var e = document.querySelector(".introjs-hints");
        return e ? e.querySelectorAll(t) : [];
    }
    function Ei(t) {
        var e = Si('.introjs-hint[data-step="'.concat(t, '"]'))[0];
        qi.call(this), e && un(e, "introjs-hidehint"), void 0 !== this._hintCloseCallback && this._hintCloseCallback.call(this, t);
    }
    function Ai() {
        var t = this;
        n(Si(".introjs-hint"), function (e) {
            Ei.call(t, e.getAttribute("data-step"));
        });
    }
    function ki() {
        var t = this,
            e = Si(".introjs-hint");
        e && e.length
            ? n(e, function (e) {
                Ti.call(t, e.getAttribute("data-step"));
            })
            : Ri.call(this, this._targetElement);
    }
    function Ti(t) {
        var e = Si('.introjs-hint[data-step="'.concat(t, '"]'))[0];
        e && In(e, /introjs-hidehint/g);
    }
    function Ni() {
        var t = this;
        n(Si(".introjs-hint"), function (e) {
            Ii.call(t, e.getAttribute("data-step"));
        });
    }
    function Ii(t) {
        var e = Si('.introjs-hint[data-step="'.concat(t, '"]'))[0];
        e && e.parentNode.removeChild(e);
    }
    function Oi() {
        var t = this,
            e = this,
            i = document.querySelector(".introjs-hints");
        null === i && (i = si("div", { className: "introjs-hints" }));
        n(this._introItems, function (n, o) {
            if (!document.querySelector('.introjs-hint[data-step="'.concat(o, '"]'))) {
                var r = si("a", { className: "introjs-hint" });
                gn(r),
                    (r.onclick = (function (t) {
                        return function (n) {
                            var i = n || window.event;
                            i.stopPropagation && i.stopPropagation(), null !== i.cancelBubble && (i.cancelBubble = !0), Li.call(e, t);
                        };
                    })(o)),
                n.hintAnimation || un(r, "introjs-hint-no-anim"),
                yn(n.element) && un(r, "introjs-fixedhint");
                var l = si("div", { className: "introjs-hint-dot" }),
                    a = si("div", { className: "introjs-hint-pulse" });
                r.appendChild(l), r.appendChild(a), r.setAttribute("data-step", o), (n.targetElement = n.element), (n.element = r), Pi.call(t, n.hintPosition, r, n.targetElement), i.appendChild(r);
            }
        }),
            document.body.appendChild(i),
        void 0 !== this._hintsAddedCallback && this._hintsAddedCallback.call(this);
    }
    function Pi(t, e, n) {
        var i = e.style,
            o = wn.call(this, n),
            r = 20,
            l = 20;
        switch (t) {
            default:
            case "top-left":
                (i.left = "".concat(o.left, "px")), (i.top = "".concat(o.top, "px"));
                break;
            case "top-right":
                (i.left = "".concat(o.left + o.width - r, "px")), (i.top = "".concat(o.top, "px"));
                break;
            case "bottom-left":
                (i.left = "".concat(o.left, "px")), (i.top = "".concat(o.top + o.height - l, "px"));
                break;
            case "bottom-right":
                (i.left = "".concat(o.left + o.width - r, "px")), (i.top = "".concat(o.top + o.height - l, "px"));
                break;
            case "middle-left":
                (i.left = "".concat(o.left, "px")), (i.top = "".concat(o.top + (o.height - l) / 2, "px"));
                break;
            case "middle-right":
                (i.left = "".concat(o.left + o.width - r, "px")), (i.top = "".concat(o.top + (o.height - l) / 2, "px"));
                break;
            case "middle-middle":
                (i.left = "".concat(o.left + (o.width - r) / 2, "px")), (i.top = "".concat(o.top + (o.height - l) / 2, "px"));
                break;
            case "bottom-middle":
                (i.left = "".concat(o.left + (o.width - r) / 2, "px")), (i.top = "".concat(o.top + o.height - l, "px"));
                break;
            case "top-middle":
                (i.left = "".concat(o.left + (o.width - r) / 2, "px")), (i.top = "".concat(o.top, "px"));
        }
    }
    function Li(t) {
        var e = document.querySelector('.introjs-hint[data-step="'.concat(t, '"]')),
            n = this._introItems[t];
        void 0 !== this._hintClickCallback && this._hintClickCallback.call(this, e, n, t);
        var i = qi.call(this);
        if (parseInt(i, 10) !== t) {
            var o = si("div", { className: "introjs-tooltip" }),
                r = si("div"),
                l = si("div"),
                a = si("div");
            (o.onclick = function (t) {
                t.stopPropagation ? t.stopPropagation() : (t.cancelBubble = !0);
            }),
                (r.className = "introjs-tooltiptext");
            var s = si("p");
            s.innerHTML = n.hint;
            var c = si("a");
            (c.className = this._options.buttonClass),
                c.setAttribute("role", "button"),
                (c.innerHTML = this._options.hintButtonLabel),
                (c.onclick = Ei.bind(this, t)),
                r.appendChild(s),
                r.appendChild(c),
                (l.className = "introjs-arrow"),
                o.appendChild(l),
                o.appendChild(r),
                (this._currentStep = e.getAttribute("data-step")),
                (a.className = "introjs-tooltipReferenceLayer introjs-hintReference"),
                a.setAttribute("data-step", e.getAttribute("data-step")),
                Pn.call(this, a),
                a.appendChild(o),
                document.body.appendChild(a),
                li.call(this, e, o, l, !0);
        }
    }
    function qi() {
        var t = document.querySelector(".introjs-hintReference");
        if (t) {
            var e = t.getAttribute("data-step");
            return t.parentNode.removeChild(t), e;
        }
    }
    function Ri(t) {
        var e = this;
        if (((this._introItems = []), this._options.hints))
            n(this._options.hints, function (t) {
                var n = Ci(t);
                "string" == typeof n.element && (n.element = document.querySelector(n.element)),
                    (n.hintPosition = n.hintPosition || e._options.hintPosition),
                    (n.hintAnimation = n.hintAnimation || e._options.hintAnimation),
                null !== n.element && e._introItems.push(n);
            });
        else {
            var o = t.querySelectorAll("*[data-hint]");
            if (!o || !o.length) return !1;
            n(o, function (t) {
                var n = t.getAttribute("data-hintanimation");
                (n = n ? "true" === n : e._options.hintAnimation),
                    e._introItems.push({
                        element: t,
                        hint: t.getAttribute("data-hint"),
                        hintPosition: t.getAttribute("data-hintposition") || e._options.hintPosition,
                        hintAnimation: n,
                        tooltipClass: t.getAttribute("data-tooltipclass"),
                        position: t.getAttribute("data-position") || e._options.tooltipPosition,
                    });
            });
        }
        Oi.call(this), i.on(document, "click", qi, this, !1), i.on(window, "resize", Mi, this, !0);
    }
    function Mi() {
        var t = this;
        n(this._introItems, function (e) {
            var n = e.targetElement,
                i = e.hintPosition,
                o = e.element;
            void 0 !== n && Pi.call(t, i, o, n);
        });
    }
    Zt(
        { target: "Array", proto: !0, forced: !Zn },
        {
            splice: function (t, e) {
                var n,
                    i,
                    o,
                    r,
                    l,
                    a,
                    s = B(this),
                    c = It(s.length),
                    u = Lt(t, c),
                    h = arguments.length;
                if ((0 === h ? (n = i = 0) : 1 === h ? ((n = 0), (i = c - u)) : ((n = h - 2), (i = ei(ti(Tt(e), 0), c - u))), c + n - i > ni)) throw TypeError(ii);
                for (o = qe(s, i), r = 0; r < i; r++) (l = u + r) in s && Pe(o, r, s[l]);
                if (((o.length = i), n < i)) {
                    for (r = u; r < c - i; r++) (a = r + n), (l = r + i) in s ? (s[a] = s[l]) : delete s[a];
                    for (r = c; r > c - i + n; r--) delete s[r - 1];
                } else if (n > i) for (r = c - i; r > u; r--) (a = r + n - 1), (l = r + i - 1) in s ? (s[a] = s[l]) : delete s[a];
                for (r = 0; r < n; r++) s[r + u] = arguments[r + 2];
                return (s.length = c - i + n), o;
            },
        }
    );
    var Bi = Math.floor,
        Hi = function (t, e) {
            var n = t.length,
                i = Bi(n / 2);
            return n < 8 ? $i(t, e) : Di(Hi(t.slice(0, i), e), Hi(t.slice(i), e), e);
        },
        $i = function (t, e) {
            for (var n, i, o = t.length, r = 1; r < o; ) {
                for (i = r, n = t[r]; i && e(t[i - 1], n) > 0; ) t[i] = t[--i];
                i !== r++ && (t[i] = n);
            }
            return t;
        },
        Di = function (t, e, n) {
            for (var i = t.length, o = e.length, r = 0, l = 0, a = []; r < i || l < o; ) r < i && l < o ? a.push(n(t[r], e[l]) <= 0 ? t[r++] : e[l++]) : a.push(r < i ? t[r++] : e[l++]);
            return a;
        },
        Fi = Hi,
        zi = S.match(/firefox\/(\d+)/i),
        Wi = !!zi && +zi[1],
        Vi = /MSIE|Trident/.test(S),
        Ui = S.match(/AppleWebKit\/(\d+)\./),
        Gi = !!Ui && +Ui[1],
        Yi = [],
        Ki = Yi.sort,
        Xi = u(function () {
            Yi.sort(void 0);
        }),
        Ji = u(function () {
            Yi.sort(null);
        }),
        Qi = Wn("sort"),
        Zi = !u(function () {
            if (N) return N < 70;
            if (!(Wi && Wi > 3)) {
                if (Vi) return !0;
                if (Gi) return Gi < 603;
                var t,
                    e,
                    n,
                    i,
                    o = "";
                for (t = 65; t < 76; t++) {
                    switch (((e = String.fromCharCode(t)), t)) {
                        case 66:
                        case 69:
                        case 70:
                        case 72:
                            n = 3;
                            break;
                        case 68:
                        case 71:
                            n = 4;
                            break;
                        default:
                            n = 2;
                    }
                    for (i = 0; i < 47; i++) Yi.push({ k: e + i, v: n });
                }
                for (
                    Yi.sort(function (t, e) {
                        return e.v - t.v;
                    }),
                        i = 0;
                    i < Yi.length;
                    i++
                )
                    (e = Yi[i].k.charAt(0)), o.charAt(o.length - 1) !== e && (o += e);
                return "DGBEFHACIJK" !== o;
            }
        });
    function to(t) {
        var e = this,
            i = t.querySelectorAll("*[data-intro]"),
            o = [];
        if (this._options.steps)
            n(this._options.steps, function (t) {
                var n = Ci(t);
                if (((n.step = o.length + 1), (n.title = n.title || ""), "string" == typeof n.element && (n.element = document.querySelector(n.element)), void 0 === n.element || null === n.element)) {
                    var i = document.querySelector(".introjsFloatingElement");
                    null === i && ((i = si("div", { className: "introjsFloatingElement" })), document.body.appendChild(i)), (n.element = i), (n.position = "floating");
                }
                (n.position = n.position || e._options.tooltipPosition),
                    (n.scrollTo = n.scrollTo || e._options.scrollTo),
                void 0 === n.disableInteraction && (n.disableInteraction = e._options.disableInteraction),
                null !== n.element && o.push(n);
            });
        else {
            var r;
            if (i.length < 1) return [];
            n(i, function (t) {
                if ((!e._options.group || t.getAttribute("data-intro-group") === e._options.group) && "none" !== t.style.display) {
                    var n = parseInt(t.getAttribute("data-step"), 10);
                    (r = t.hasAttribute("data-disable-interaction") ? !!t.getAttribute("data-disable-interaction") : e._options.disableInteraction),
                    n > 0 &&
                    (o[n - 1] = {
                        element: t,
                        title: t.getAttribute("data-title") || "",
                        intro: t.getAttribute("data-intro"),
                        step: parseInt(t.getAttribute("data-step"), 10),
                        tooltipClass: t.getAttribute("data-tooltipclass"),
                        highlightClass: t.getAttribute("data-highlightclass"),
                        position: t.getAttribute("data-position") || e._options.tooltipPosition,
                        scrollTo: t.getAttribute("data-scrollto") || e._options.scrollTo,
                        disableInteraction: r,
                    });
                }
            });
            var l = 0;
            n(i, function (t) {
                if ((!e._options.group || t.getAttribute("data-intro-group") === e._options.group) && null === t.getAttribute("data-step")) {
                    for (; void 0 !== o[l]; ) l++;
                    (r = t.hasAttribute("data-disable-interaction") ? !!t.getAttribute("data-disable-interaction") : e._options.disableInteraction),
                        (o[l] = {
                            element: t,
                            title: t.getAttribute("data-title") || "",
                            intro: t.getAttribute("data-intro"),
                            step: l + 1,
                            tooltipClass: t.getAttribute("data-tooltipclass"),
                            highlightClass: t.getAttribute("data-highlightclass"),
                            position: t.getAttribute("data-position") || e._options.tooltipPosition,
                            scrollTo: t.getAttribute("data-scrollto") || e._options.scrollTo,
                            disableInteraction: r,
                        });
                }
            });
        }
        for (var a = [], s = 0; s < o.length; s++) o[s] && a.push(o[s]);
        return (
            (o = a).sort(function (t, e) {
                return t.step - e.step;
            }),
                o
        );
    }
    function eo(t) {
        var e = document.querySelector(".introjs-tooltipReferenceLayer"),
            n = document.querySelector(".introjs-helperLayer"),
            i = document.querySelector(".introjs-disableInteraction");
        if (
            (Pn.call(this, n),
                Pn.call(this, e),
                Pn.call(this, i),
            t && ((this._introItems = to.call(this, this._targetElement)), pi.call(this, e, this._introItems[this._currentStep]), vi.call(this, e)),
            void 0 !== this._currentStep && null !== this._currentStep)
        ) {
            var o = document.querySelector(".introjs-arrow"),
                r = document.querySelector(".introjs-tooltip");
            li.call(this, this._introItems[this._currentStep].element, r, o);
        }
        return Mi.call(this), this;
    }
    function no() {
        eo.call(this);
    }
    function io(t, e) {
        if (t && t.parentElement) {
            var n = t.parentElement;
            e
                ? (On(t, { opacity: "0" }),
                    window.setTimeout(function () {
                        try {
                            n.removeChild(t);
                        } catch (t) {}
                    }, 500))
                : n.removeChild(t);
        }
    }
    function oo(t, e) {
        var o = !0;
        if ((void 0 !== this._introBeforeExitCallback && (o = this._introBeforeExitCallback.call(this)), e || !1 !== o)) {
            var r = t.querySelectorAll(".introjs-overlay");
            r &&
            r.length &&
            n(r, function (t) {
                return io(t);
            }),
                io(t.querySelector(".introjs-helperLayer"), !0),
                io(t.querySelector(".introjs-tooltipReferenceLayer")),
                io(t.querySelector(".introjs-disableInteraction")),
                io(document.querySelector(".introjsFloatingElement")),
                ai(),
                i.off(window, "keydown", ji, this, !0),
                i.off(window, "resize", no, this, !0),
            void 0 !== this._introExitCallback && this._introExitCallback.call(this),
                (this._currentStep = void 0);
        }
    }
    function ro(t) {
        var e = this,
            n = si("div", { className: "introjs-overlay" });
        return (
            On(n, { top: 0, bottom: 0, left: 0, right: 0, position: "fixed" }),
                t.appendChild(n),
            !0 === this._options.exitOnOverlayClick &&
            (On(n, { cursor: "pointer" }),
                (n.onclick = function () {
                    oo.call(e, t);
                })),
                !0
        );
    }
    function lo(t) {
        var e = to.call(this, t);
        return 0 === e.length || ((this._introItems = e), ro.call(this, t) && (wi.call(this), this._options.keyboardNavigation && i.on(window, "keydown", ji, this, !0), i.on(window, "resize", no, this, !0))), !1;
    }
    Zt(
        { target: "Array", proto: !0, forced: Xi || !Ji || !Qi || !Zi },
        {
            sort: function (t) {
                void 0 !== t && on(t);
                var e = B(this);
                if (Zi) return void 0 === t ? Ki.call(e) : Ki.call(e, t);
                var n,
                    i,
                    o = [],
                    r = It(e.length);
                for (i = 0; i < r; i++) i in e && o.push(e[i]);
                for (
                    n = (o = Fi(
                        o,
                        (function (t) {
                            return function (e, n) {
                                return void 0 === n ? -1 : void 0 === e ? 1 : void 0 !== t ? +t(e, n) || 0 : te(e) > te(n) ? 1 : -1;
                            };
                        })(t)
                    )).length,
                        i = 0;
                    i < n;

                )
                    e[i] = o[i++];
                for (; i < r; ) delete e[i++];
                return e;
            },
        }
    );
    function ao(t) {
        (this._targetElement = t),
            (this._introItems = []),
            (this._options = {
                nextLabel: "Next",
                prevLabel: "Back",
                skipLabel: "×",
                doneLabel: "Done",
                hidePrev: !1,
                hideNext: !1,
                nextToDone: !0,
                tooltipPosition: "bottom",
                tooltipClass: "",
                group: "",
                highlightClass: "",
                exitOnEsc: !0,
                exitOnOverlayClick: !0,
                showStepNumbers: !1,
                keyboardNavigation: !0,
                showButtons: !0,
                showBullets: !0,
                showProgress: !1,
                scrollToElement: !0,
                scrollTo: "element",
                scrollPadding: 30,
                overlayOpacity: 0.5,
                autoPosition: !0,
                positionPrecedence: ["bottom", "top", "right", "left"],
                disableInteraction: !1,
                helperElementPadding: 10,
                hintPosition: "top-middle",
                hintButtonLabel: "Got it",
                hintAnimation: !0,
                buttonClass: "introjs-button",
                progressBarAdditionalClass: !1,
            });
    }
    var so = function n(i) {
        var o;
        if ("object" === t(i)) o = new ao(i);
        else if ("string" == typeof i) {
            var r = document.querySelector(i);
            if (!r) throw new Error("There is no element with given selector.");
            o = new ao(r);
        } else o = new ao(document.body);
        return (n.instances[e(o, "introjs-instance")] = o), o;
    };
    return (
        (so.version = "4.2.2"),
            (so.instances = {}),
            (so.fn = ao.prototype = {
                clone: function () {
                    return new ao(this);
                },
                setOption: function (t, e) {
                    return (this._options[t] = e), this;
                },
                setOptions: function (t) {
                    return (
                        (this._options = (function (t, e) {
                            var n,
                                i = {};
                            for (n in t) i[n] = t[n];
                            for (n in e) i[n] = e[n];
                            return i;
                        })(this._options, t)),
                            this
                    );
                },
                start: function () {
                    return lo.call(this, this._targetElement), this;
                },
                goToStep: function (t) {
                    return bi.call(this, t), this;
                },
                addStep: function (t) {
                    return this._options.steps || (this._options.steps = []), this._options.steps.push(t), this;
                },
                addSteps: function (t) {
                    if (t.length) {
                        for (var e = 0; e < t.length; e++) this.addStep(t[e]);
                        return this;
                    }
                },
                goToStepNumber: function (t) {
                    return yi.call(this, t), this;
                },
                nextStep: function () {
                    return wi.call(this), this;
                },
                previousStep: function () {
                    return _i.call(this), this;
                },
                currentStep: function () {
                    return xi.call(this);
                },
                exit: function (t) {
                    return oo.call(this, this._targetElement, t), this;
                },
                refresh: function (t) {
                    return eo.call(this, t), this;
                },
                onbeforechange: function (t) {
                    if ("function" != typeof t) throw new Error("Provided callback for onbeforechange was not a function");
                    return (this._introBeforeChangeCallback = t), this;
                },
                onchange: function (t) {
                    if ("function" != typeof t) throw new Error("Provided callback for onchange was not a function.");
                    return (this._introChangeCallback = t), this;
                },
                onafterchange: function (t) {
                    if ("function" != typeof t) throw new Error("Provided callback for onafterchange was not a function");
                    return (this._introAfterChangeCallback = t), this;
                },
                oncomplete: function (t) {
                    if ("function" != typeof t) throw new Error("Provided callback for oncomplete was not a function.");
                    return (this._introCompleteCallback = t), this;
                },
                onhintsadded: function (t) {
                    if ("function" != typeof t) throw new Error("Provided callback for onhintsadded was not a function.");
                    return (this._hintsAddedCallback = t), this;
                },
                onhintclick: function (t) {
                    if ("function" != typeof t) throw new Error("Provided callback for onhintclick was not a function.");
                    return (this._hintClickCallback = t), this;
                },
                onhintclose: function (t) {
                    if ("function" != typeof t) throw new Error("Provided callback for onhintclose was not a function.");
                    return (this._hintCloseCallback = t), this;
                },
                onexit: function (t) {
                    if ("function" != typeof t) throw new Error("Provided callback for onexit was not a function.");
                    return (this._introExitCallback = t), this;
                },
                onskip: function (t) {
                    if ("function" != typeof t) throw new Error("Provided callback for onskip was not a function.");
                    return (this._introSkipCallback = t), this;
                },
                onbeforeexit: function (t) {
                    if ("function" != typeof t) throw new Error("Provided callback for onbeforeexit was not a function.");
                    return (this._introBeforeExitCallback = t), this;
                },
                addHints: function () {
                    return Ri.call(this, this._targetElement), this;
                },
                hideHint: function (t) {
                    return Ei.call(this, t), this;
                },
                hideHints: function () {
                    return Ai.call(this), this;
                },
                showHint: function (t) {
                    return Ti.call(this, t), this;
                },
                showHints: function () {
                    return ki.call(this), this;
                },
                removeHints: function () {
                    return Ni.call(this), this;
                },
                removeHint: function (t) {
                    return Ii().call(this, t), this;
                },
                showHintDialog: function (t) {
                    return Li.call(this, t), this;
                },
            }),
            so
    );
});