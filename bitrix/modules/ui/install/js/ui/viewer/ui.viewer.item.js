;(function () {

	'use strict';

	BX.namespace('BX.UI.Viewer');

	BX.UI.Viewer.Item = function(options)
	{
		options = options || {};

		/**
		 * @type {BX.UI.Viewer.Controller}
		 */
		this.controller = null;
		this.title = options.title;
		this.src = options.src;
		this.nakedActions = options.nakedActions;
		this.actions = options.actions;
		this.contentType = options.contentType;
		this.isLoaded = false;
		this.isLoading = false;
		this.sourceNode = null;
		this.transformationPromise = null;
		this.transformationTimeoutId = null;
		this.viewerGroupBy = null;
		this.transformationTimeout = options.transformationTimeout || 15000;
		this.layout = {
			container: null
		};

		this.options = options;

		this.init();
	};

	BX.UI.Viewer.Item.prototype =
	{
		setController: function (controller)
		{
			if (!(controller instanceof BX.UI.Viewer.Controller))
			{
				throw new Error("BX.UI.Viewer.Item: 'controller' has to be instance of BX.UI.Viewer.Controller.");
			}

			this.controller = controller;
		},

		/**
		 * @param {HTMLElement} node
		 */
		setPropertiesByNode: function (node)
		{
			this.title = node.dataset.title || node.title || node.alt;
			this.src = node.dataset.src;
			this.viewerGroupBy = node.dataset.viewerGroupBy;
			this.nakedActions = node.dataset.actions? JSON.parse(node.dataset.actions) : undefined;
		},

		/**
		 * @param {HTMLElement} node
		 */
		bindSourceNode: function (node)
		{
			this.sourceNode = node;
		},

		applyReloadOptions: function (options)
		{},

		isPullConnected: function()
		{
			if(top.BX.PULL)
			{
				// pull_v2
				if(BX.type.isFunction(top.BX.PULL.isConnected))
				{
					return top.BX.PULL.isConnected();
				}
				else
				{
					var debugInfo = top.BX.PULL.getDebugInfoArray();
					return debugInfo.connected;
				}
			}

			return false;
		},

		registerTransformationHandler: function(pullTag)
		{
			if (this.isLoaded)
			{
				return;
			}

			this.controller.setTextOnLoading(BX.message('JS_UI_VIEWER_ITEM_TRANSFORMATION_IN_PROGRESS'));

			if (this.isPullConnected())
			{
				BX.addCustomEvent('onPullEvent-main', function (command, params) {
					if (command === 'transformationComplete' && this.transformationPromise)
					{
						this.loadData().then(function(){
							this.transformationPromise.fulfill(this);
						}.bind(this));
					}
				}.bind(this));

				console.log('BX.PULL.extendWatch');
				BX.PULL.extendWatch(pullTag);
			}
			else
			{
				setTimeout(function(){
					BX.ajax.promise({
						url: BX.util.add_url_param(this.src, {ts: 'bxviewer'}),
						method: 'GET',
						dataType: 'json',
						headers: [{
							name: 'BX-Viewer-check-transformation',
							value: null
						}]
					}).then(function(response){
						if (!response.data || !response.data.transformation)
						{
							this.registerTransformationHandler();
						}
						else
						{
							this.loadData().then(function(){
								this.transformationPromise.fulfill(this);
							}.bind(this));
						}
					}.bind(this));
				}.bind(this), 5000);
			}

			this.transformationTimeoutId = setTimeout(function(){
				if (!this.isLoaded)
				{
					console.log('Throw transformationTimeout');
					if (this._loadPromise)
					{
						this._loadPromise.reject({
							status: "timeout",
							message: BX.message("JS_UI_VIEWER_ITEM_TRANSFORMATION_TIMEOUT"),
							item: this
						});

						this.isLoading = false;
					}
				}
				else
				{
					console.log('We don\'t have transformationTimeout :) ');
				}

				this.resetTransformationTimeout();
			}.bind(this), this.transformationTimeout);
		},

		resetTransformationTimeout: function ()
		{
			if(this.transformationTimeoutId)
			{
				clearTimeout(this.transformationTimeoutId);
			}

			this.transformationTimeoutId = null;
		},

		init: function ()
		{},

		load: function ()
		{
			var promise = new BX.Promise();

			if (this.isLoaded)
			{
				promise.fulfill(this);
				console.log('isLoaded');

				return promise;
			}
			if (this.isLoading)
			{
				console.log('isLoading');

				return this._loadPromise;
			}

			this.isLoading = true;
			this._loadPromise = this.loadData().then(function(item){
				this.isLoaded = true;
				this.isLoading = false;

				return item;
			}.bind(this)).catch(function (reason) {
				console.log('catch');
				this.isLoaded = false;
				this.isLoading = false;

				if(!reason.item)
				{
					reason.item = this;
				}

				var promise = new BX.Promise();
				promise.reject(reason);

				return promise;
			}.bind(this));

			console.log('will load');

			return this._loadPromise;
		},

		getSrc: function()
		{
			return this.src;
		},

		getTitle: function()
		{
			return this.title;
		},

		getGroupBy: function()
		{
			return this.viewerGroupBy;
		},

		getNakedActions: function()
		{
			if (typeof this.nakedActions === 'undefined')
			{
				return [{
					type: 'download'
				}];
			}

			return this.nakedActions;
		},

		setActions: function(actions)
		{
			this.actions = actions;
		},

		getActions: function()
		{
			return this.actions;
		},

		/**
		 * @returns {BX.Promise}
		 */
		loadData: function ()
		{
			var promise = new BX.Promise();
			promise.setAutoResolve(true);
			promise.fulfill(this);

			return promise;
		},

		render: function ()
		{},

		afterRender: function ()
		{}
	};

	/**
	 * @extends {BX.UI.Viewer.Item}
	 * @param options
	 * @constructor
	 */
	BX.UI.Viewer.Image = function (options)
	{
		options = options || {};

		BX.UI.Viewer.Item.apply(this, arguments);

		this.resizedSrc = options.resizedSrc;
		this.width = options.width;
		this.height = options.height;
		/**
		 * @type {HTMLImageElement}
		 */
		this.imageNode = null;
		this.layout = {
			container: null
		}
	};

	BX.UI.Viewer.Image.prototype =
	{
		__proto__: BX.UI.Viewer.Item.prototype,
		constructor: BX.UI.Viewer.Item,

		/**
		 * @param {HTMLElement} node
		 */
		setPropertiesByNode: function (node)
		{
			BX.UI.Viewer.Item.prototype.setPropertiesByNode.apply(this, arguments);

			this.src = node.dataset.src || node.src;
			this.width = node.dataset.width;
			this.height = node.dataset.height;
		},

		loadData: function ()
		{
			var promise = new BX.Promise();

			if (!this.shouldRunLocalResize())
			{
				this.resizedSrc = this.src;
			}

			if (!this.resizedSrc)
			{
				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function () {
					if(xhr.readyState !== XMLHttpRequest.DONE)
					{
						return;
					}
					if ((xhr.status === 200 || xhr.status === 0) && xhr.response)
					{
						console.log('resize image');
						this.resizedSrc = URL.createObjectURL(xhr.response);
						this.imageNode = new Image();
						this.imageNode.src = this.resizedSrc;
						this.imageNode.onload = function () {
							promise.fulfill(this);
						}.bind(this);
					}
					else
					{
						promise.reject({
							item: this,
							type: 'error'
						});
					}

				}.bind(this);
				xhr.open('GET', BX.util.add_url_param(this.src, {ts: 'bxviewer'}), true);
				xhr.responseType = 'blob';
				xhr.setRequestHeader('BX-Viewer-image', 'x');
				xhr.send();
			}
			else
			{
				this.imageNode = new Image();
				this.imageNode.onload = function () {
					promise.fulfill(this);
				}.bind(this);
				this.imageNode.onerror = this.imageNode.onabort = function (event) {
					console.log('reject');
					promise.reject({
						item: this,
						type: 'error'
					});
				}.bind(this);

				this.imageNode.src = this.resizedSrc;
			}

			return promise;
		},

		shouldRunLocalResize: function ()
		{
			var isAbsoluteLink = new RegExp('^([a-z]+://|//)', 'i');
			if (!isAbsoluteLink.test(this.src))
			{
				return true;
			}

			if (!BX.getClass('URL'))
			{
				return this.src.indexOf(location.hostname) !== -1;
			}

			try
			{
				return (new URL(this.src)).hostname === location.hostname;
			}
			catch(e)
			{}

			return false;
		},

		render: function ()
		{
			var item = document.createDocumentFragment();

			item.appendChild(this.imageNode);

			if (this.title)
			{
				item.appendChild(BX.create('div', {
					props: {
						className: 'viewer-inner-fullsize'
					},
					children: [
						BX.create('a', {
							props: {
								href: BX.util.add_url_param(this.src, {ts: 'bxviewer', ibxShowImage: 1}),
								target: '_blank'
							},
							text: BX.message('JS_UI_VIEWER_IMAGE_VIEW_FULL_SIZE')
						})
					]
				}));
			}

			this.imageNode.alt = this.title;

			return item;
		},

		afterRender: function ()
		{
			//it's a dirty hack for IE11 and working with Image and blob content to prevent unexpected width&height attributes
			if (!window.chrome)
			{
				setTimeout(function () {
					this.imageNode.removeAttribute('width');
					this.imageNode.removeAttribute('height');
				}.bind(this), 200);
			}
		}
	};


	/**
	 * @extends {BX.UI.Viewer.Item}
	 * @param options
	 * @constructor
	 */
	BX.UI.Viewer.PlainText = function (options)
	{
		options = options || {};

		BX.UI.Viewer.Item.apply(this, arguments);

		this.content = options.content;
	};

	BX.UI.Viewer.PlainText.prototype =
	{
		__proto__: BX.UI.Viewer.Item.prototype,
		constructor: BX.UI.Viewer.Item,

		/**
		 * @param {HTMLElement} node
		 */
		setPropertiesByNode: function (node)
		{
			BX.UI.Viewer.Item.prototype.setPropertiesByNode.apply(this, arguments);

			this.content = node.dataset.content;
		},

		render: function ()
		{
			var contentNode = BX.create('span', {
				text: this.content
			});

			contentNode.style.fontSize = '18px';
			contentNode.style.color = 'white';

			return contentNode;
		}
	};

	/**
	 * @extends {BX.UI.Viewer.Item}
	 * @param options
	 * @constructor
	 */
	BX.UI.Viewer.Unknown = function (options)
	{
		BX.UI.Viewer.Item.apply(this, arguments);
	};

	BX.UI.Viewer.Unknown.prototype =
	{
		__proto__: BX.UI.Viewer.Item.prototype,
		constructor: BX.UI.Viewer.Item,

		render: function ()
		{
			return BX.create('div', {
				props: {
					className: 'ui-viewer-error'
				},
				children: [
					BX.create('div', {
						props: {
							className: 'ui-viewer-info-title'
						},
						text: BX.message('JS_UI_VIEWER_ITEM_UNKNOWN_TITLE')
					})
				]
			});
		}
	};

	/**
	 * @extends {BX.UI.Viewer.Item}
	 * @param options
	 * @constructor
	 */
	BX.UI.Viewer.Video = function (options)
	{
		options = options || {};

		BX.UI.Viewer.Item.apply(this, arguments);

		this.player = null;
		if (this.src)
		{
			this.playerId = 'playerId_' + this.hashCode(this.src) + (Math.floor(Math.random() * Math.floor(10000)));
		}
		this.sources = [];
		this.transformationPromise = null;
		this.forceTransformation = false;
	};

	BX.UI.Viewer.Video.prototype =
	{
		__proto__: BX.UI.Viewer.Item.prototype,
		constructor: BX.UI.Viewer.Item,

		/**
		 * @param {HTMLElement} node
		 */
		setPropertiesByNode: function (node)
		{
			BX.UI.Viewer.Item.prototype.setPropertiesByNode.apply(this, arguments);

			this.playerId = 'playerId_' + this.hashCode(this.src) + (Math.floor(Math.random() * Math.floor(10000)));
		},

		hashCode: function (string)
		{
			var h = 0, l = string.length, i = 0;
			if (l > 0)
			{
				while (i < l)
					h = (h << 5) - h + string.charCodeAt(i++) | 0;
			}
			return h;
		},

		applyReloadOptions: function (options)
		{
			if (options.forceTransformation)
			{
				this.forceTransformation = true;
			}
		},

		init: function () 
		{
			BX.addCustomEvent('PlayerManager.Player:onAfterInit', function(player)
			{
				if (player.id !== this.playerId)
				{
					return;
				}

				if (player.vjsPlayer.error() && !this.forceTransformation)
				{
					console.log('forceTransformation');
					this.controller.reload(this, {
						forceTransformation: true
					});
				}

			}.bind(this));
		},

		loadData: function ()
		{
			var promise = new BX.Promise();

			var headers = [
				{
					name: 'BX-Viewer-src',
					value: this.src
				}
			];

			headers.push({
				name: this.forceTransformation? 'BX-Viewer-force-transformation' : 'BX-Viewer',
				value: 'video'
			});

			var ajaxPromise = BX.ajax.promise({
				url: BX.util.add_url_param(this.src, {ts: 'bxviewer'}),
				method: 'GET',
				dataType: 'json',
				headers: headers
			});

			ajaxPromise.then(function (response) {
				if (!response || !response.data)
				{
					promise.reject({
						item: this,
						type: 'error',
						errors: response.errors || []
					});

					return;
				}

				if (response.data.hasOwnProperty('pullTag'))
				{
					this.transformationPromise = promise;
					this.registerTransformationHandler(response.data.pullTag);
				}
				else
				{
					if (response.data.data)
					{
						this.width = response.data.data.width;
						this.height = response.data.data.height;
						this.sources = response.data.data.sources;
					}

					if (response.data.html)
					{
						var html = BX.processHTML(response.data.html);

						BX.load(html.STYLE, function(){
							BX.ajax.processScripts(html.SCRIPT, undefined, function(){
								promise.fulfill(this);
							}.bind(this));
						}.bind(this));
					}
				}
			}.bind(this));

			return promise;
		},

		render: function ()
		{
			this.player = new BX.Fileman.Player(this.playerId, {
				width: this.width,
				height: this.height,
				sources: this.sources
			});

			return this.player.createElement();
		},

		afterRender: function()
		{
			this.player.init();
		}
	};

	/**
	 * @extends {BX.UI.Viewer.Item}
	 * @param options
	 * @constructor
	 */
	BX.UI.Viewer.Document = function (options)
	{
		BX.UI.Viewer.Item.apply(this, arguments);
		this.contentNode = null;
		this.previewHtml = null;
		this.previewScriptToProcess = null;
		this.transformationPromise = null;
	};

	BX.UI.Viewer.Document.prototype =
	{
		__proto__: BX.UI.Viewer.Item.prototype,
		constructor: BX.UI.Viewer.Item,

		/**
		 * @param {HTMLElement} node
		 */
		setPropertiesByNode: function (node)
		{
			BX.UI.Viewer.Item.prototype.setPropertiesByNode.apply(this, arguments);
		},

		loadData: function ()
		{
			var promise = new BX.Promise();
			if (this.previewHtml)
			{
				this.processPreviewHtml(this.previewHtml);
				promise.fulfill(this);

				return promise;
			}

			var ajaxPromise = BX.ajax.promise({
				url: BX.util.add_url_param(this.src, {ts: 'bxviewer'}),
				method: 'GET',
				dataType: 'json',
				headers: [
					{
						name: 'BX-Viewer-src',
						value: this.src
					},
					{
						name: 'BX-Viewer',
						value: 'document'
					}
				]
			});

			ajaxPromise.then(function (response) {
				if (!response || !response.data)
				{
					promise.reject({
						item: this,
						type: 'error'
					});

					return;
				}


				if (response.data.hasOwnProperty('pullTag'))
				{
					this.transformationPromise = promise;
					this.registerTransformationHandler(response.data.pullTag);
				}

				if (response.data.html)
				{
					this.previewHtml = response.data.html;
					this.processPreviewHtml(response.data.html);
					promise.fulfill(this);
				}
			}.bind(this));

			return promise;
		},

		processPreviewHtml: function (previewHtml)
		{
			console.log('processPreviewHtml');
			var html = BX.processHTML(previewHtml);

			if (!this.contentNode)
			{
				this.contentNode = BX.create('div', {
					html: html.HTML
				});
			}

			if (!!html.SCRIPT)
			{
				this.previewScriptToProcess = html.SCRIPT;
			}
		},

		render: function ()
		{
			return this.contentNode;
		},

		afterRender: function ()
		{
			if (this.previewScriptToProcess)
			{
				BX.ajax.processScripts(this.previewScriptToProcess);
			}

			var pdfContainer = this.contentNode.querySelector('.bx-pdf-container');
			if (pdfContainer)
			{
				var height = Math.min(this.controller.getItemContainer().clientHeight, parseInt(pdfContainer.style.height, 10)) - 50;
				pdfContainer.style.height = height + 'px';
			}
		}
	};

})();