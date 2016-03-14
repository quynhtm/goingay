	
	/**
	 * Created by uoon (http://vnjs.net);
	 * Version: 1.0;
	 * License: GPL license;
	 * Email: mnx2012@gmail.com;
	 */
	 
	var F_NAME = "Focus";

	(function() {
		
		var currentWindow = window, currentDocument = currentWindow.document;
		
		// Check everything.
		var assert = function(data) {
			
			function isExists(obj) {
				return (obj != null && obj != undefined);
			}
			
			function notExists(obj) {
				return !isExists(obj);
			}
			
			return {
				source: [data],
				
				isExists: function() {
					var src = this.source[0];
					return isExists(src);
				},
				
				notExists: function() {
					var src = this.source[0];
					return !isExists(src);
				},
				
				isArray: function() {
					var src = this.source[0];
					return (isExists(src) && src.constructor == Array);
				},
				
				isElement: function() {
					var src = this.source[0];
					return (isExists(src) && src.tagName && 1 == src.nodeType);
				},

				isFunction: function() {
					var src = this.source[0];
					return (isExists(src) && src instanceof Function);	
				},
				
				isJsObject: function() {
					var src = this.source[0];
					return (isExists(src) && src.constructor == Object);
				},
				
				isNumber: function() {
					var src = this.source[0];
					return (isExists(src) && src.constructor == Number);
				},
				
				isObject: function() {
					var src = this.source[0];
					return (isExists(src) && "object" === typeof src);
				},
				
				isString: function() {
					var src = this.source[0];
					return (isExists(src) && "string" === typeof src);
				},
				
				isBlank: function() {
					var src = this.source[0];
					return (this.isString(src) && "" == src.replace(/^\s+|\s+$/g, ""));
				},
				
				isRegExp: function() {
					var src = this.source[0];
					return (isExists(src) && src.constructor == RegExp);
				},
				
				isTextNode: function() {
					var src = this.source[0];
					return (isExists(src) && 3 == src.nodeType);
				},
				
				isIE6: function() {
					return (/MSIE 6/).test(navigator.userAgent);
				},
				
				isIE7: function() {
					return (/MSIE 7/).test(navigator.userAgent);
				},
				
				isIE8: function() {
					return (/MSIE 8/).test(navigator.userAgent);
				},
				
				isIE: function() {
					return (/MSIE/).test(navigator.userAgent);
				},
				
				isIPad: function() {
					return (/iPad/).test(navigator.userAgent);
				},
				
				isIPod: function() {
					return (/iPod/).test(navigator.userAgent);
				},
				
				isOpera: function() {
					return (/Opera/).test(navigator.userAgent);
				},
				
				isWebkit: function() {
					return (/Webkit/).test(navigator.userAgent);
				},
				
				isIPhone: function() {
					return (/iPhone/).test(navigator.userAgent);
				},
				
				isFirefox: function() {
					return (/Firefox/).test(navigator.userAgent);
				},
				
				isMobile: function() {
					return isExists(currentWindow.onorientationchange);
				}
			}
		};
		
		// store temporary data;
		var temporary = {
			method: {},
			number: {},
			object: {},
			boxnote: {},
			variable: {}
		};
		
		/*
			example: 
				var a = {
					x: "x",
					y: "y"
				};
				var b = {
					u: "u",
					v: {
						t: "t",
						z: "z"
					}
				};
				var c = function(){};
				copy(a, b).to(c);
		*/
		var copy = function() {
			var arg = arguments;
			return {
				to: function(target) {
					target = assert(target).isExists() ? target : {};
					for (var i = 0; i < arg.length; ++i) {
						var source = arg[i];
						for (var o in source) {
							if (!Object.prototype[o]) {
								if (assert(source[o]).isJsObject()) {
									assert(target[o]).isJsObject() || (target[o] = {});
									copy(source[o]).to(target[o]);
								} else {
									// Override.
									target[o] = source[o];
								}
							}
						}
					}
					return target;
				}
			}
		};
		
		var selector = function(path, func) {
			var isId = /#((?:[\w\u00c0-\uFFFF_-]|\\.)+)/, eleNode = null;
			(path.replace(isId, "") != path) && (eleNode = currentDocument.getElementById(path.replace(isId, "$1")));
			if (eleNode) {
				if (assert(func).isFunction()) {
					return func(eleNode)
				}
				return eleNode;
			}
			return null;
		};
		
		// for extend from user;
		var extension = {
			common: {},
			array: {},
			html: {},
			json: {},
			number: {},
			object: {},
			string: {},
			utility: {},
			validate: {}
		};
		
		var extend = {
			
			common: function(data) {
			
				function cover(src) {
					if (assert(src).notExists()) {
						return cover.source[0];
					} 
				};
				
				var publicity = {
					source: [data],
					areNotEqual: function(expect, message) {
						if (this.source[0] == expect) {
							temporary.boxnote.push(message);
						}
						return this;
					},
					areEqual: function(expect, message) {
						if (this.source[0] != expect) {
							temporary.boxnote.push(message);
						}
						return this;
					},
					areSame: function(expect, message) {
						if (this.source[0] !== expect) {
							temporary.boxnote.push(message);
						}
						return this;
					},
					areNotSame: function(expect, message) {
						if (this.source[0] === expect) {
							temporary.boxnote.push(message);
						}
						return this;
					},
					showMessage: function(target) {
						if (assert(target).isElement()) {
							target.innerHTML = "<div>" + temporary.boxnote.join("</div><div>") + "</div>";
						} else {
							alert(temporary.boxnote.join("\n"));
						}
					},
					clearMessage: function() {
						temporary.boxnote = [];
					}
				};
				
				return copy(extension.common, assert(), publicity).to(cover);
			},
			array: function(data) {
				
				function cover(src) {
					if (assert(src).notExists()) {
						return  cover.source[0];
					} 
				};
				
				var publicity = {
					source: [data]
				};
				
				return copy(extend.common(), extension.array, publicity).to(cover);
			},
			html: function(data) {
				
				function cover(src) {
					if (assert(src).notExists()) {
						return cover.source[0];
					} 
				};
				
				var publicity = {
					source: [data],
					add: function(option) {
						extend.utility.updateSource("html", this);
						var setting = {
							className: null,
							style: null,
							event: null,
							attr: null,
							child: null
						};
							
						copy(option).to(setting);

						assert(setting.className).isExists() && this.addClass(setting.className);
						
						assert(setting.style).isExists() && this.setStyle(setting.style);
						
						assert(setting.event).isObject() && this.addEvent(setting.event);
						
						assert(setting.attr).isObject() && this.setAttr(setting.attr);
						
						assert(setting.child).isExists() && this.addChild(setting.child);
						
						return this;
					},
					setAttr: function(attribute) {
						var eleNode = extend.utility.updateSource("html", this);
						for (var o in attribute) {
							if (!Object.prototype[o]) {
								eleNode.setAttribute(o.toString(), attribute[o]);
							}
						}
						return this;
					},
					addClass: function (clazz) {
						var eleNode = extend.utility.updateSource("html", this);
							oldClass = eleNode.className;
						eleNode.className = !assert(oldClass).isBlank() ? oldClass += " " + clazz : clazz;
						return this;
					},
					addChild: function() {
						var eleNode = extend.utility.updateSource("html", this),
							child = null,
							length = arguments.length;
						
						for (var i = 0; i < length; ++ i) {
							child = arguments[i];
							if (assert(child).isElement()) {
								eleNode.appendChild(child);
							} else if (assert(child.source[0]).isElement()) {
								// only apply for this library;
								eleNode.appendChild(child.source[0]);
							}
						}	
						return this;
					},
					setStyle: function(style) {
						var eleNode = extend.utility.updateSource("html", this);
						if (assert(style).isString()) {
							eleNode.setAttribute("style", style);
						} else if (assert(style).isJsObject()) {
							var st = eleNode.style;
							for (var o in style) {
								if (o == "float") {
									st["cssStyle"] = style[o];
									st["styleFloat"] = style[o];
								} else {
									st[o] = style[o];
								}
							}
						}
						return this;
					},
					addEvent: function(evt) {
						extend.utility.updateSource("html", this);
						extend.utility.registerEvent(this.source[0], evt);
						return this;
					},
					setOpacity: function(value) {
						extend.utility.updateSource("html", this);
						(!assert().isIE() && (this.source[0].style.opacity = value/100))  
							|| (this.source[0].style.filter = "alpha(opacity = value)".replace("value", value));
						return this;
					},
					getStyle: function(property) {
						extend.utility.updateSource("html", this);
						var value, match, eleNode = this.source[0], type = extend.utility.getStyleType(property);
						if (eleNode.currentStyle && !assert().isOpera()) { 
							if (type == "opacity") {
								value = eleNode.currentStyle["filter"];
								match = value.match(/(.*)opacity\s*=\s*(\w+)(.*)/i);
								value = match ? isNaN(parseFloat(match[2])) ? 100 : parseFloat(match[2]) : 100;
							} else { 
								value = eleNode.currentStyle[property];
							}
						} else if (currentDocument.defaultView && currentDocument.defaultView.getComputedStyle) {
							property = property.replace(/[(A-Z)]/g, function(match){return "-" + match.toLowerCase()});
							value = currentDocument.defaultView.getComputedStyle(eleNode, null).getPropertyValue(property);
							value = (type == "opacity") ? 100 * value : value; 
						}
						
						switch (type) {
							case "color": 
								return extend.string(value).toColor(true);
							case "dimension": case "position":
								return (value == "auto" || value == "normal") ? "0px" : value;
							default:
								return value;
						}
					},
					getHeight: function() {
						var eleNode = extend.utility.updateSource("html", this),
							height = (eleNode.height) ? eleNode.height : eleNode.offsetWidth;
						return height;
					},
					getWidth: function() {
						var eleNode = extend.utility.updateSource("html", this),
							width = (eleNode.width) ? eleNode.width : eleNode.offsetWidth;
						return width;
					},
					show: function() {
						var eleNode = extend.utility.updateSource("html", this);
						eleNode.style.display = "";
						eleNode.style.visibility = "visible";
						return this;
					},
					hide: function() {
						var eleNode = extend.utility.updateSource("html", this);
						eleNode.style.display = "none";
						return this;
					},
					toggle: function() {
						var eleNode = extend.utility.updateSource("html", this);
						if (eleNode.style.display == "none") {
							eleNode.style.display = "";
							eleNode.style.visibility = "visible";
						} else {
							eleNode.style.display = "none";
						}
						return this;
					},
					hidden: function() {
						var eleNode = extend.utility.updateSource("html", this);
						eleNode.style.visibility = "hidden";
						return this;
					},
					visible: function() {
						var eleNode = extend.utility.updateSource("html", this);
						eleNode.style.visibility = "visible";
						return this;
					},
					setHTML: function(html) {
						var eleNode = extend.utility.updateSource("html", this);
						if (assert(eleNode.value).isExists()) {
							eleNode.value = html;
						} else if (assert(eleNode.innerHTML).isExists()) {
							eleNode.innerHTML = html; 
						}
						return this;
					},
					getHTML: function() {
						var eleNode = extend.utility.updateSource("html", this);
						if (assert(eleNode.value).isExists()) {
							return eleNode.value;
						} else if (assert(eleNode.innerHTML).isExists()) {
							return eleNode.innerHTML; 
						}
					},
					appendHTML: function(html) {
						var eleNode = extend.utility.updateSource("html", this);
						if (assert(eleNode.innerHTML).isExists()) {
							eleNode.innerHTML += html;
						} else if (assert(eleNode.value).isExists()) {
							eleNode.value += html;
						}
						return this;
					},
					appendTo: function(element) {
						assert(element).isElement() && element.appendChild(extend.utility.updateSource("html", this));
						return this;
					},
					getFirstChild: function() {
						extend.utility.updateSource("html", this);
						var firstChild = this.source[0].firstChild;
						while(firstChild && firstChild.nodeType != 1) {
							firstChild = firstChild.nextSibling;
						}
						return extend.html(firstChild);
					},
					getLastChild: function() {
						extend.utility.updateSource("html", this);
						var lastChild = this.source[0].lastChild;
						while(lastChild && lastChild.nodeType != 1) {
							lastChild = lastChild.previousSibling;
						}
						return extend.html(lastChild);
					}
				};
				
				return copy(extend.common(), extension.html, publicity).to(cover);
			},
			number: function(data) {
				
				function cover(src) {
					if (assert(src).notExists()) {
						return  cover.source[0];
					} 
				};

				var publicity = {
					source: [data]
				};
				
				return copy(extend.common(), extension.number, publicity).to(cover);
			},
			object: function(data) {
					
				function cover(src) {
					if (assert(src).notExists()) {
						return cover.source[0];
					} 
				};
				
				var publicity = {
					source: [data],
					// append method, properties of an object to exists module;
					appendTo: function(module) {
						if (module == "utility") {
							for (var i in this.source[0]) {
								! (i in currentWindow[F_NAME])
								&& (currentWindow[F_NAME][i] = this.source[0][i]);
							}
						} else if (module in extension) {
							for (var i in this.source[0]) {
								! (i in extension[module])
								&& (extension[module][i] = this.source[0][i]);
							}
						}
					},
					createModule: function(module) {
						// create a new module from an object; 
						currentWindow[F_NAME][module] = this.source[0];
					}
				};
				
				return copy(extend.common(), extension.object, publicity).to(cover);
			},
			string: function(data) {
				
				function cover(src) {
					if (assert(src).isString() || assert(src).isNumber()) {
						cover.source.push(src);
					} else if (src == true) {
						return cover.source.join("");
					} else if (assert(src).notExists()) {
						return extend.utility.updateSource('html', cover);
					} else if (assert(src).isFunction()) {
						// using callback function when selector;
						return selector(cover.source.join(""), src);
					} 
					return cover;
				};
				
				var publicity = {
					source: [data],
					upper: function(state) {
						extend.utility.updateSource('string', this);			
						this.source[0] = this.source[0].toUpperCase();
						return (state === true) ? this.source[0] : this;
					},
					lower: function() {
						extend.utility.updateSource('string', this);
						this.source[0] = this.source[0].toLowerCase();
						return (state === true) ? this.source[0] : this;
					},
					trim: function(state) {
						extend.utility.updateSource('string', this);
						this.source[0] = this.source[0].replace(/^\s+|\s+$/g, "");
						return (state === true) ? this.source[0] : this;
					},
					toColor: function(state) {
						/*
							Convert text color to rgb value.
							example : Focus("green").toColor(true);
							return: rgb(0, 128, 0);
						*/
						var colorName = extend.utitlity.updateSource('string', this);
						var table = extend.utility.createElement({
								tagName: "table",
								style: {
									display: "none",
									color: colorName
								},
								attr: {
									bgColor: colorName
								}
							}).appendTo(currentDocument.body),
							value = null,
							match = null;
						value = assert().isIE() ? table.bgColor : currentDocument.defaultView.getComputedStyle(table, null).getPropertyValue("color");
						currentDocument.body.removeChild(table);
						match = value.match(/^#(\w{2})(\w{2})(\w{2})/);
						value = !match ? value : "rgb(" + parseInt(match[1], 16) + ", " + parseInt(match[2], 16) + ", " + parseInt(match[3], 16) + ")";
						this.source = [value];
						return (state === true) ? this.source[0] : this;
					},
					urlEncode: function(state) {
						extend.utility.updateSource('string', this);
						return (state === true) ? encodeURIComponent(this.source[0]) : this;
					},
					urlDecode: function(state) {
						extend.utility.updateSource('string', this);
						return (state === true) ? decodeURIComponent(this.source[0]) : this;
					}
				};
				
				return copy(extend.html(), extend.common(), extension.string, publicity).to(cover);
			},
			utility: {
				storeFunction: function(id, src) {
					var id = assert(id).isExists() ? id : this.getNumber();
					assert(src).isFunction() && (temporary.method[id] = src);
					return id;
				},
				callFunction: function(id) {
					var func = temporary.method[id];
					if (assert(func).isFunction()) {
						return func;
					}
				},
				unstoreFunction: function(id) {
					if (assert(temporary.method[id]).isExists()) {
						delete temporary.method[id];
					}
				},
				getNumber: (
					function() {
						var number = 0;
						return function() {
							return ++ number;
						}
					}
				)(),
				copy: copy,
				storeObject: function(id, src) {
					var id = assert(id).isExists() ? id : this.getNumber();
					assert(src).isObject() && (temporary.object[id] = src);
					return id;
				},
				callObject: function(id) {
					return temporary.object[id];
				},
				unstoreObject: function unstoreObject(id) {
					delete temporary.object[id];
				},
				updateSource: function(module, object) {
					return this.callFunction(module)(object);
				},
				addDetection: function(module, detector) {
					this.storeFunction(module, detector);
				},
				getEventSource: function(event) {
					return (event && event.target) ? extend.html(event.target) 
							: currentWindow.event ? extend.html(currentWindow.event.srcElement) : null;
				},
				getPageHeight: function() {
					return currentDocument.body.scrollHeight;
				},
				getPageWidth: function() {
					return currentDocument.body.scrollWidth;
				},
				getScreenHeight: function() {
					return currentWindow.screen.availHeight;
				},
				getScreenWidth: function() {
					return currentWindow.screen.availWidth;
				},
				getTime: function() {
					return new Date().getTime();
				},
				getX: function(src) {
					if (src && src.nodeName) {
						var x = 0;
						while (src) {
							x += src.offsetLeft;
							src = src.offsetParent;
						}
						return x;
					} else if (src.clientX !== undefined) {
						return src.clientX + currentDocument.body.scrollLeft + currentDocument.documentElement.scrollLeft;
					}
				},
				getY: function(src) {
					if (src && src.nodeName) {
						var y = 0;
						while (src) {
							y += src.offsetTop;
							src = src.offsetParent;
						}
						return y;
					} else if (src.clientY !== undefined) {
						return src.clientY + currentDocument.body.scrollTop + currentDocument.documentElement.scrollTop;
					}
				},
				getStyleType: function(style) {
					switch (style) {
						case "backgroundColor": case "color":
							return "color";
						case "fontSize": case "height": case "letterSpacing": case "marginBottom": case "marginLeft": case "marginRight": case "marginTop": case "paddingBottom" : case "paddingLeft": case "paddingRight": case "paddingTop": case "width": case "wordSpacing":
							return "dimension";
						case "opacity":
							return "opacity";
						case "bottom": case "left": case "right": case "top":
							return "position";
						default:
							return "chaos";
					}
				},
				createId: function(src) {
					return extend.string(src || F_NAME)("-")(this.getNumber())("-")(this.getTime())(true);
				},
				createElement: function(config) {
					/*
						Focus.createElement({
							id: Focus.getNumber(),
							className: "abc",
							style: {
								border: "1px solid red",
								height: "40px"
							}
						});
					*/
					var setting = {
						tagName: "div",
						id: null,
						className: null,
						innerHTML: null,
						// add.
						attr: null,
						event: null,
						style: null
						
					};
					
					copy(config).to(setting);
					
					var newNode = currentDocument.createElement(setting.tagName);
					
					assert(setting.id).isExists() && (newNode.id = setting.id);
					
					assert(setting.innerHTML).isExists() && (newNode.innerHTML = setting.innerHTML);
										
					assert(setting.className).isExists() && (newNode.className = setting.className);
		
					newNode = extend.html(newNode);

					assert(setting.attr).isExists() && newNode.setAttr(setting.attr);		
					
					assert(setting.event).isObject() && newNode.addEvent(setting.event);
					
					assert(setting.style).isExists() && newNode.setStyle(setting.style);
					
					return newNode;
				},
				registerEvent: function(obj, evt) {
					for (var o in evt) {
						if (!Object.prototype[o]) {
							if (obj.addEventlistenerer) {
								obj.addEventlistenerer(o, evt[o], false);
							} else if (obj.attachEvent) {
								obj.attachEvent("on" + o, evt[o]);
							} else {
								obj["on" + o] = evt[o];
							}
						}
					}
					return this;
				},
				loadScript: function(path) {
					var	body = currentDocument.body,
						newScript = null;
					if (assert(body).notExists()) {	
						document.write("<" + "script type='text/javascript' src=" + path + "></" + "script" + ">");
					} else {
						newScript = this.createElement({
							tagName: "script",
							attr: {
								src: path,
								type: "text/javascript"
							}
						})();
						body.appendChild(newScript);
					}
				},
				getWindow: function() {
					return currentWindow;
				},
				getDocument: function() {
					return currentWindow.document;
				},
				updateDocument: function(win) {
					currentWindow = win;
					currentDocument = win.document;
				},
				getSelfName: function() {
					return F_NAME;
				}
			}
		};
		
		extend.utility.addDetection('common', function(object) {
			return object.source[0];
		});
		
		extend.utility.addDetection('string', function(object) {
			object.source.length &&	(object.source = [object.source.join('')]);
			return object.source[0];
		});
		
		extend.utility.addDetection("html", function(object) {
			//TO DO: need change when updated selector;
			assert(object.source[0]).isString() && (object.source = [selector(object.source.join(""))]);
			return object.source[0];
		});
		
		function filter(data) {
			if (assert(data).isArray()) {
				return extend.array(data);
			}
			if (assert(data).isNumber()) {
				return extend.number(data);
			}
			if (assert(data).isString()) {
				return extend.string(data);
			}
			if (assert(data).isElement()) {
				return extend.html(data);
			} 
			if (assert(data).isJsObject()) {
				return extend.object(data);
			}
			return extend.common(data);
		};
		
		!assert(F_NAME).isString() && (F_NAME = "Focus");
		
		currentWindow[F_NAME] = extension.common[F_NAME] = filter;
		
		copy(extend.utility).to(currentWindow[F_NAME]);
		
	})();
	
	
	// dragable module;
	
	(function() {
	
		var f = window[F_NAME],
			currentWindow = f.getWindow(),
			currentDocument = f.getDocument();

		function preventEvent(event) {
			var event = event || currentWindow.event;
			event.cancelBubble = true;
		}
		
		function ignoreDagDrop(group) {
			if (group && group.length) {
				for (var o = 0; o < group.length; ++o) {
					group[o].onmousedown = function(event) {
						var event = event || currentWindow.event;
						event.cancelBubble = true;
					}
				}
			}
		}
					
		var publicity = {
			setDragable: function(config) {
					var ADN = f.updateSource('html', this);
					var setting = {
						x: 0,
						y: 0,
						proxy: null,
						lockX: false,
						lockY: false,
						onDrag: function() {},
						onMove: function() {},
						onDrop: function() {}
					};
					
					f.copy(config).to(setting);
					
					var proxy = setting.proxy || ADN;
					
					function mouseDown(event) {
						var event = event || currentWindow.event;
						setting.onDrag.call({self: proxy, event: event});
						if (!(event.button == 2 || event.which == 3)) {
							var position = f(proxy).getStyle("position"),
								left = f(proxy).getStyle("left"),
								top = f(proxy).getStyle("top");
							
							f(proxy).setStyle({position: (position != "absolute") ? "relative" : "absolute"});
							!setting.lockX && f(proxy).setStyle({left: parseInt(left) ? left : "0px"}); 
							!setting.lockY && f(proxy).setStyle({top: parseInt(left) ? top : "0px"}); 
							
							setting.x = event.clientX;
							setting.y = event.clientY;
							
							document.onmousemove = mouseMove;
							document.onmouseup = function(event) {
								var event = event || currentWindow.event,
									source = f.getEventSource(event)();
								if (source != proxy) {
									document.onmousemove = null;
								}
								mouseUp(event);
							};
							proxy.onmouseup = mouseUp;
							return false;
						}
					};
					
					function mouseMove(event) {
						var event = event || currentWindow.event;
						!setting.lockX && f(proxy).setStyle({left: parseInt(proxy.style.left) + (event.clientX - setting.x) + "px"});
						!setting.lockY && f(proxy).setStyle({top: parseInt(proxy.style.top) + (event.clientY - setting.y) + "px"});
						setting.x = event.clientX;
						setting.y = event.clientY;
						setting.onMove.call({self: proxy, event: event});
						return false;
					};
					
					function mouseUp(event) {
						var event = event || currentWindow.event;
						document.onmousemove = null;
						document.onmouseup = null;
						proxy.onmouseup = null;
						setting.onDrop.call({self: proxy, event: event});
						return false;
					};
					
					ADN.onmousedown = mouseDown;

					var aForm = ADN.getElementsByTagName("form");
					if (aForm && aForm.length) {
						ignoreDagDrop(aForm);
					} else {
						var aInput = ADN.getElementsByTagName("input");
						ignoreDagDrop(aInput);
						var aIframe = ADN.getElementsByTagName("iframe");
						ignoreDagDrop(aIframe);
						var aTextarea = ADN.getElementsByTagName("textarea");
						ignoreDagDrop(aTextarea);
					}
					
					return this;
				},
				isIn: function(object, event) {
					if (!f.isElement(object)) return false;
					
					var ADN = f.updateSource("html", this);
					var Xmin = f.getX(object);
					var Xmax = Xmin + object.offsetWidth;
					var Ymin = f.getY(object);
					var Ymax = Ymin + object.offsetHeight;
					var X = f.getX(event);
					var Y = f.getY(event);
					return (Xmin < X && X < Xmax) 
							&& (Ymin < Y && Y < Ymax) ? true : false;
				}
		};
		
		f(publicity).appendTo("html");
	})();
	
	
	// debug module;
	
	(function() {
	
		var f = window[F_NAME],
			holdId,
			flag = true,
			temporary = [],
			textareaValue = "";
		
		var currentWindow = f.getWindow(),
			currentDocument = currentWindow.document;
		
		var setting = {
			viewCover: false,
			zIndex: 999,
			align: ["left", "right", "middle"][2]
		},
		style = {
			borderTop: "1px solid #cccccc",
			top: "0px",
			width: "64%",
			margin: "auto",
			padding: "3px",
			color: "white",
			backgroundColor: "black"
		};
		// store child object;
		var childObject = [];			
		
		function discover(o) {
			var node = f.createElement({style:{margin: "10px"}});
			if (f(o).isString() || f(o).isNumber()) {
				node.setHTML(o);
			} else {
				var v = o && o.toString ? o.toString() : o, innerHTML = "";
				f(o).isArray() && (v = "[]");
				f(o).isObject() && (v = "{}");
				node.setHTML(
					f("<div style='clear:left; line-height: 18px;'>")
					 ("<div style='color: #9b1a00; overflow: hidden; width: 246px; float: left;'>")
						("<span style='padding-left: 18px;'>source</span>")
					 ("</div>")
					 ("<div style='padding-left: 246px;'><xmp>")(v)("</xmp></div>")
					 ("</div>")(true)
				);
				try {
					for (var p in o) {
						try {
							v = o[p] != null ? o[p] : '""';
						} catch(e) {
							v = "Can't access !!!";
						}
						if (f(v).isObject()) {
							childObject.push(v);
							innerHTML = f("<div style='width: 246px; overflow: hidden; float: left;'>")
												("<span style='margin-right: 6px;'>[+]</span>")
												("<span style='color: #9b1a00; cursor: pointer;' onclick='")(F_NAME)('.callFunction("viewChild")(this, ')(childObject.length - 1)(")'>")(p)("</span>")
											("</div>")
											("<div style='margin-left: 246px;'><xmp>Object {...}</xmp></div>")
											("<div style='margin-left: 49px; display: none;'></div>")(true);
						} else {
							v = v.toString ? v.toString() : v;
							innerHTML = f("<div style='width: 246px; overflow: hidden; float: left;'>")
												("<span style='margin: 0px 12px 0px 8px;'>-</span>")
												("<span style='color: #9b1a00'>")(p)("</span>")
											("</div>")
											("<div style='margin-left: 246px;'><xmp>")(v)("</xmp></div>")(true);
						}
						
						node.addChild(
							f.createElement({
								style: "clear:left; line-height: 18px;",
								innerHTML: innerHTML
							})
						);
					}
				} catch(e) {
					node.setHTML("Can't access !!!");
				}
			}
			return node();
		};
		
		var viewChild = f.storeFunction(
			"viewChild",
			function (clickElement, childId) {
				var parent = clickElement.parentNode.parentNode,
					target = f(parent).getLastChild();
				if (target.getFirstChild().isExists()) {
					target.toggle();
				} else {
					target.addChild(discover(childObject[childId])).show();
				}
			}
		);
			
		function removeConsole() {
			if (holdId) {
				var console = currentDocument.getElementById(holdId);
				currentDocument.body.removeChild(console);
				holdId = null;
				childObject = [];
				textareaValue = null;
			}
		}
				
		var publicity = {
			viewSource: function(config) {

				f.copy(config).to(setting);
				(setting.align == "left") && f.copy({position: "absolute", left: "0px"}).to(style);
				(setting.align == "right") && f.copy({position: "absolute", right: "0px"}).to(style);
				(setting.align == "middle") && f.copy({position: "relative"}).to(style);
				f.copy({zIndex: setting.zIndex}).to(style);
				
				var src = (setting.viewCover == true) ? this : this.source[0];
				/* Only show one console,
					if want to show more obeject,
						please add them in to an array
							then view this array source.
				*/
				var consoleId = holdId || f.createId();
				
				if (f(holdId).notExists()) {
					holdId = consoleId;
					var container = f.createElement({
						id: consoleId,
						event: {
							"mousedown": function(event) {
								var event = event || currentWindow.event;
								event.cancelBubble = true;
							}
						},
						style: {cursor: "default", top: "0px", position: "absolute", fontFamily: "Courier New", left: "0px", width: "100%", fontSize: "12px", height: "0px", zIndex: 101}
					}).appendTo(currentDocument.body);
				} else {
					// Remove content;
					var container = currentDocument.getElementById(consoleId);
					while (container.firstChild) {
						container.removeChild(container.firstChild);
					}
					container = f(container);
				}
				
				var info = f.createElement({
					style: style
				});
				var title = f.createElement({
					innerHTML: f("<div style='float:left;'>")
									("<span>[ + ]</span>")
								("<span style='cursor: pointer;' onclick='" + F_NAME + "(window).viewSource(true);'> window </span>")
								("<span style='cursor: pointer;' onclick='" + F_NAME + "(document).viewSource(true);'> / document </span>")
								("</div>")(true),
					style: {padding: "3px 0px 0px 0px", height: "20px"}
				});
				var button = f.createElement({
					style: {textAlign: "right", margin: "0px 0px 0px 200px", cursor: "move"}
				});
				var minimize = f.createElement({
					innerHTML: "--",
					tagName: "span",
					style: {color: "red", fontWeight: "bold", cursor: "pointer", marginRight: "12px"},
					event: {
						mousedown: function(event) {
							var event = event || currentWindow.event;
							event.cancelBubble = true;
							resizeConsole();
						}
					}
				});
				var close = f.createElement({
					innerHTML: "[X]",
					tagName: "span",
					style: {color: "red", fontWeight: "bold", cursor: "pointer"},
					event: {
						mousedown: function(event) {
							var event = event || currentWindow.event;
							event.cancelBubble = true;
							removeConsole();
						}
					}
				});
				var dynamic = f.createElement({
					style: {position: "relative", width: "100%"}
				});
				
				var textarea = f.createElement({
					innerHTML: textareaValue,
					tagName: "textarea",
					style: {height: "43px", width: "100%", overflow: "auto", marginLeft: (function(){return f().isIE() ? "-2px" : "0px"})()}
				});
				var active = f.createElement({
					innerHTML: "eval",
					tagName: "span",
					event: {
						mousedown: function(event) {
							var event = event || currentWindow.event;
							event.cancelBubble = true;
							textareaValue = textarea.getHTML();
							textareaValue && eval(textareaValue);
						}
					},
					style: {position: "absolute", bottom: "0px", right: "0px",  padding: "0px 8px", color: "black", border: "2px solid green"}
				});
				var content = f.createElement({
					style: {background: "#848484", borderTop: "2px solid green", height: "300px", width: "100%", overflow: "auto"},
					event: {
						"mousedown": function(event) {
							var event = event || currentWindow.event;
							event.cancelBubble = true;
						}
					}
				});

				container.addChild(
					info.addChild(
						title.addChild(button.addChild(minimize, close)),
						dynamic.addChild(textarea, active),
						content
					)
				);
									
				function resizeConsole() {
					if (content.getStyle('display') != "none") {
						content.hide();
						minimize.setHTML("[]");
					} else {
						content.show();
						minimize.setHTML("--");
					}
				}
			
				title.setDragable({proxy: container()});
				content.addChild(discover(src));
				return this;
			},
			log: function(config) {
				var source = this(true) || this(),
					light = "white";
				if (!flag) {
					flag = true;
					light = "black";
				} else {
					flag = false;
				}
				if (f(source).isString() || f(source).isNumber()) {
					temporary.push(
						f("<div style='width: 100%; color: ")(light)("'><span style='margin: 0px 12px 0px 8px;'>-</span>")
							(source)("</div>")(true)
					);
				} else {
					temporary.push(
						f("<div style='width: 100%; color: ")(light)("'>")
							(discover(source).innerHTML)
							("</div>")(true)
					);
				}
				f(temporary.join("")).viewSource(config);
				return this;
			},
			clear: function() {
				flag = true;
				temporary = [];
				f("").viewSource();
				return this;
			},
			viewStream: function(config) {
				var storeFunction = [],
					callee = arguments.callee.caller;
				while (callee) {
					storeFunction.unshift(callee.toString());
					callee = callee.arguments.callee.caller;
				}
				f(storeFunction).viewSource(config);
				return this;
			}
		}
		f(publicity).appendTo("common");
	})();
