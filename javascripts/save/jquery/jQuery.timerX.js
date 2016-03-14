/*\**************************************************************************************\
|+| The MIT License
||| 
|+| TimerX Plugin version 1.0.3-VN
||| 
|+| Copyright (c) 2010 Vorspire, Vita-Nex
||| 
|+| Permission is hereby granted, free of charge, to any person obtaining a copy
||| of this software and associated documentation files (the "Software"), to deal
||| in the Software without restriction, including without limitation the rights
||| to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
||| copies of the Software, and to permit persons to whom the Software is
||| furnished to do so, subject to the following conditions:
||| 
|+| The above copyright notice and this permission notice shall be included in
||| all copies or substantial portions of the Software.
||| 
|+| THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
||| IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
||| FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
||| AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
||| LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
||| OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
||| THE SOFTWARE.
\|/*************************************************************************************/

(function ($)
{
	var timerProfilerClass = function ()
	{
		var __instances = {};

		var __count = function ()
		{ return __instances.length; };

		var __add = function (timer)
		{
			if (!__has(timer))
			{
				if (!__instances[timer.index()])
				{ __instances[timer.index()] = timer; }
			}

			return timer;
		};

		var __remove = function (timer)
		{
			if (__has(timer))
			{ delete __instances[timer.index()]; }

			return timer;
		};

		var __contains = function (index)
		{
			if (__instances[index])
			{ return true; }

			return false;
		};

		var __has = function (timer)
		{
			if (__instances[timer.index()])
			{ return true; }

			return false;
		};

		var __slice = function (timer)
		{
			if (timer.state() == "ERROR" && timer.error())
			{
				console.log('timerClass object entered an error state: ' + timer.error());
				console.log(__profile(timer));
			}

			return timer;
		};

		var __profile = function (timer)
		{
			var p = {};

			for (var fn in timer)
			{
				var key = fn;

				if (key != 'start' && key != 'stop' && key != 'crash' && key != 'pause')
				{ p[key] = timer[fn](); }
			}

			return p;
		};

		var __object =
		{
			instances: function () { return __instances; },
			add: __add,
			remove: __remove,
			contains: __contains,
			has: __has,
			slice: __slice,
			profile: __profile,
			count: __count
		};

		return __object;
	};

	$.extend({ timerProfiler: timerProfilerClass() });

	var timerClass = function (options)
	{
		var defaults =
		{
			parent: $(document),
			delay: 0,
			interval: 0,
			repeat: false,
			callback: function (timer, args) { },
			args: {}
		};

		if (!options)
		{ options = {}; }

		var opt = $.extend(true, defaults, options);

		var __parent = opt.parent;
		var __delay = opt.delay;
		var __interval = opt.interval;
		var __repeat = opt.repeat;
		var __callback = opt.callback;
		var __args = opt.args;

		var __index = null;
		var __error = null;
		var __state = "OK";
		var __tid = 0;
		var __ticks = 0;
		var __current = new Date();
		var __next = new Date(__current.getTime() + __delay);
		var __last;
		var __running = false;
		var __paused = false;

		var __crash = function (exception)
		{
			__state = "ERROR";
			__error = exception;

			return __object;
		};

		var __tick = function ()
		{
			try
			{
				__ticks++;

				__current = new Date();

				if (__repeat === true || __repeat > 0)
				{ __next = new Date(__current.getTime() + __interval); }
				else
				{ __next = null; }

				__callback(__object, __args);
				__last = __current;
			}
			catch (e)
			{ __crash(e); }

			return __object;
		};

		var __pause = function ()
		{
			try
			{
				__running = false;
				__paused = true;
			}
			catch (e)
			{ __crash(e); }

			return __object;
		};

		var __start = function ()
		{
			try
			{
				__running = true;
				__register();

				if (__paused === false)
				{
					if (__ticks > 0)
					{ __tid = setTimeout(__slice, __interval); }
					else
					{ __tid = setTimeout(__slice, __delay); }
				}
			}
			catch (e)
			{ __crash(e); }

			return __object;
		};

		var __stop = function ()
		{
			try
			{
				__pause();
				__unregister();
				clearTimeout(__tid);
			}
			catch (e)
			{ __crash(e); }

			return __object;
		};

		var __slice = function ()
		{
			try
			{
				$.timerProfiler.slice(__object);
				__tick();

				if (__repeat === false || __repeat <= 0)
				{ __stop(); }
				else if (__repeat === true || __ticks < __repeat)
				{ __start(); }
			}
			catch (e)
			{ __crash(e); }

			return __object;
		};

		var __register = function () { $.timerProfiler.add(__object); };
		var __unregister = function () { $.timerProfiler.remove(__object); };

		var __object =
		{
			end: function () { return __parent; },
			parent: function () { return __parent; },
			delay: function (val)
			{
				if (!val)
				{ return __delay; }
				else
				{
					__delay = val;
					return __object;
				}
			},
			interval: function (val)
			{
				if (!val)
				{ return __interval; }
				else
				{
					__interval = val;
					return __object;
				}
			},
			repeat: function (val)
			{
				if (!val)
				{ return __repeat; }
				else
				{
					__repeat = val;
					return __object;
				}
			},
			callback: function (val)
			{
				if (!val)
				{ return __callback; }
				else
				{
					__callback = val;
					return __object;
				}
			},
			args: function (val)
			{
				if (!val)
				{ return __args; }
				else
				{
					__args = val;
					return __object;
				}
			},
			error: function () { return __error; },
			state: function () { return __state; },
			tid: function () { return __tid; },
			ticks: function () { return __ticks; },
			current: function () { return __current; },
			next: function () { return __next; },
			last: function () { return __last; },
			running: function () { return __running; },
			paused: function () { return __paused; },
			index: function ()
			{
				try
				{
					if (!__index)
					{
						var release = false;

						while (!release)
						{
							var idx = new Date().getTime().toString();

							if ($.timerProfiler.contains(idx) === false)
							{
								__index = idx;
								release = true;
							}
						}
					}
				}
				catch (e)
				{ __crash(e); }

				return __index;
			},
			crash: __crash,
			start: __start,
			stop: __stop,
			pause: __pause
		};

		return __object;
	};

	$.extend(
	{
		timerCreate: function (options)
		{
			if (!options)
			{ options = { parent: $(document) }; }
			else if (!options.parent)
			{ options.parent = $(document); }

			return timerClass(options);
		},
		timerDelayCall: function (options)
		{
			if (!options)
			{ options = { parent: $(document) }; }
			else if (!options.parent)
			{ options.parent = $(document); }

			return timerClass(options).start();
		}
	});

	$.fn.extend(
	{
		timerCreate: function (options)
		{
			if (this != jQuery)
			{
				if (!options)
				{ options = { parent: $(this) }; }
				else if (!options.parent)
				{ options.parent = $(this); }
			}

			return timerClass(options);
		},
		timerDelayCall: function (options)
		{
			if (this != jQuery)
			{
				if (!options)
				{ options = { parent: $(this) }; }
				else if (!options.parent)
				{ options.parent = $(this); }
			}

			return timerClass(options).start();
		}
	});
})(jQuery);