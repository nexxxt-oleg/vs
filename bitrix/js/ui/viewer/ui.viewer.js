;(function () {

	'use strict';

	BX.namespace('BX.UI.Viewer');

	BX.UI.Viewer.Controller = function(options)
	{
		/**
		 * @type {BX.UI.Viewer.Item[]}
		 */
		this.items = null;
		this.currentIndex = null;
		this.handlers = {};

		this.setItems(options.items || []);

		this.zIndex = options.zIndex || 999999;
		this.cycleMode = options.hasOwnProperty('cycleMode')? options.cycleMode : true;
		this.optionsByGroup = {};
		this.layout = {
			container: null,
			content: null,
			inner: null,
			itemContainer: null,
			next: null,
			prev: null,
			close: null,
			error: null,
			loader: null,
			loaderContainer: null,
			loaderText: null,
			panel: null
		};

		/**
		 * @type {BX.UI.ActionPanel}
		 */
		this.actionPanel = new BX.UI.ActionPanel({
			darkMode: true,
			floatMode: false,
			autoHide: false,
			zIndex: this.zIndex,
			showTotalSelectedBlock: false,
			showResetAllBlock: false,
			alignItems: 'center',
			renderTo: function() {
				return this.getPanelWrapper();
			}.bind(this)
		});

		this.init();
	};

	BX.UI.Viewer.Controller.prototype = {
		/**
		 * @param {HTMLElement} node
		 */
		buildItemListByNode: function (node)
		{
			if (!BX.type.isDomNode(node) || !node.dataset)
			{
				return [];
			}

			if (!node.dataset.hasOwnProperty('viewer'))
			{
				return [];
			}

			if (!node.dataset.viewerGroupBy)
			{
				return [
					BX.UI.Viewer.buildItemByNode(node)
				];
			}

			var nodes = [].slice.call(node.ownerDocument.querySelectorAll("[data-viewer][data-viewer-group-by='" + node.dataset.viewerGroupBy + "']"));

			return nodes.map(function(node) {
				return BX.UI.Viewer.buildItemByNode(node);
			});
		},

		handleDocumentClick: function (event)
		{
			var target = BX.getEventTarget(event);
			var items = this.buildItemListByNode(target);
			if (items.length === 0)
			{
				return;
			}

			this.setItems(items).then(function(){
				this.open(this.getIndexByNode(target));
			}.bind(this));

			event.preventDefault();
		},

		bindEvents: function ()
		{
			this.handlers.keyPress = this.handleKeyPress.bind(this);
			this.handlers.touchStart = this.handleTouchStart.bind(this);
			this.handlers.touchEnd = this.handleTouchEnd.bind(this);
			this.handlers.resize = this.adjustViewerHeight.bind(this);
			this.handlers.showNext = this.showNext.bind(this);
			this.handlers.showPrev = this.showPrev.bind(this);
			this.handlers.close = this.close.bind(this);
			this.handlers.handleClickOnItemContainer = this.handleClickOnItemContainer.bind(this);
			this.handlers.handleSliderOpen = this.handleSliderOpen.bind(this);
			this.handlers.handleSliderCloseComplete = this.handleSliderCloseComplete.bind(this);
			this.handlers.handleSliderCloseByEsc = this.handleSliderCloseByEsc.bind(this);

			BX.bind(document, 'keydown', this.handlers.keyPress);
			BX.bind(window, 'resize', this.handlers.resize);
			BX.bind(this.getItemContainer(), 'touchstart', this.handlers.touchStart);
			BX.bind(this.getItemContainer(), 'touchend', this.handlers.touchEnd);

			BX.bind(this.getItemContainer(), 'click', this.handlers.handleClickOnItemContainer);
			BX.bind(this.getNextButton(), 'click', this.handlers.showNext);
			BX.bind(this.getPrevButton(), 'click', this.handlers.showPrev);
			BX.bind(this.getCloseButton(), 'click', this.handlers.close);

			BX.addCustomEvent('SidePanel.Slider:onOpen', this.handlers.handleSliderOpen);
			BX.addCustomEvent('SidePanel.Slider:onCloseComplete', this.handlers.handleSliderCloseComplete);
			BX.addCustomEvent('SidePanel.Slider:onCloseByEsc', this.handlers.handleSliderCloseByEsc);			
		},

		/**
		 * @param {BX.SidePanel.Event} event
		 */
		handleSliderCloseByEsc: function(event)
		{
			if (this.isOpen() && (this.getZindex() > event.getSlider().getZindex()))
			{
				event.denyAction();
			}
		},

		/**
		 * @param {BX.SidePanel.Event} event
		 */
		handleSliderCloseComplete: function(event)
		{
			var slider = BX.SidePanel.Instance.getTopSlider();
			if (slider)
			{
				console.log('grab zIndex from closed slider', slider.getZindex());
				this.setZindex(slider.getZindex() - 1);
			}
			else
			{
				console.log('reset zIndex by originalZIndex', this.originalZIndex);
				this.setZindex(this.originalZIndex);
				this.originalZIndex = null;
			}
		},

		/**
		 * @param {BX.SidePanel.Event} event
		 */
		handleSliderOpen: function (event)
		{
			if (!this.originalZIndex)
			{
				this.originalZIndex = this.getZindex();
			}
			console.log('SidePanel.Slider:onOpen', this.originalZIndex, event.getSlider().getZindex() - 1);

			this.setZindex(event.getSlider().getZindex() - 1);
		},

		adjustZindex: function ()
		{
			if (!BX.getClass('BX.SidePanel.Instance'))
			{
				return;
			}

			if (!BX.SidePanel.Instance.isOpen())
			{
				this.setZindex(this.originalZIndex || this.zIndex);
				this.originalZIndex = null;

				return;
			}

			//we have to show viewer over sidepanel
			var slider = BX.SidePanel.Instance.getTopSlider();
			this.originalZIndex = this.zIndex;

			this.setZindex(slider.getZindex() + 1);
		},

		unbindEvents: function()
		{
			BX.unbind(document, 'keydown', this.handlers.keyPress);
			BX.unbind(window, 'resize', this.handlers.resize);
			BX.unbind(this.getItemContainer(), 'touchstart', this.handlers.touchStart);
			BX.unbind(this.getItemContainer(), 'touchend', this.handlers.touchEnd);

			BX.unbind(this.getItemContainer(), 'click', this.handlers.handleClickOnItemContainer);
			BX.unbind(this.getNextButton(), 'click', this.handlers.showNext);
			BX.unbind(this.getPrevButton(), 'click', this.handlers.showPrev);
			BX.unbind(this.getCloseButton(), 'click', this.handlers.close);

			BX.removeCustomEvent('SidePanel.Slider:onOpen', this.handlers.handleSliderOpen);
			BX.removeCustomEvent('SidePanel.Slider:onCloseComplete', this.handlers.handleSliderCloseComplete);
		},

		init: function ()
		{},

		openByNode: function (node)
		{
			var items = this.buildItemListByNode(node);
			if (items.length === 0)
			{
				return;
			}

			this.setItems(items).then(function(){
				this.open(this.getIndexByNode(node));
			}.bind(this));
		},

		runActionByNode: function (node, actionId, additionalParams)
		{
			var items = this.buildItemListByNode(node);
			if (items.length === 0)
			{
				return;
			}

			this.setItems(items).then(function(){
				this.runAction(this.getIndexByNode(node), actionId, additionalParams);
			}.bind(this));
		},

		runAction: function (index, actionId, additionalParams)
		{
			var item = this.getItemByIndex(index);
			var actionToRun = item.getActions().find(function (action) {
				return action.id === actionId;
			});

			console.log('actionToRun', actionId, actionToRun);
			if (!BX.type.isFunction(actionToRun.action))
			{
				console.log('action is not a function');
				return;
			}

			actionToRun.action.call(this, item, additionalParams);
		},

		getZindex: function ()
		{
			return this.zIndex;
		},

		setZindex: function (zIndex)
		{
			console.log('setZindex', zIndex);
			this.zIndex = zIndex;
			this.getViewerContainer().style.zIndex = zIndex;
		},

		/**
		 * @param items
		 * @return {Promise<extensionsCollection>}
		 */
		setItems: function (items)
		{
			if (!BX.type.isArray(items))
			{
				throw new Error("BX.UI.Viewer.Controller.setItems: 'items' has to be Array.");
			}

			BX.onCustomEvent('BX.UI.Viewer.Controller:onSetItems', [this, items]);

			this.items = items;
			this.items.forEach(function (item) {
				item.setController(this);
			}, this);

			return this.loadExtensions(this.collectExtensionsForAction(items));
		},

		/**
		 *
		 * @param {String|String[]} extensions - Extension name
		 * @return {Promise<extensionsCollection>}
		 */
		loadExtensions: function (extensions)
		{
			return BX.loadExt(extensions);
		},

		/**
		 *
		 * @param {BX.UI.Viewer.Item[]} items
		 * @return {Array}
		 */
		collectExtensionsForAction: function (items)
		{
			var extensionSet = new Set();

			items.forEach(function (item) {
				var actions = item.getActions() || [];
				actions.forEach(function (action) {
					if (!action.extension)
					{
						return;
					}

					if (!BX.type.isArray(action.extension))
					{
						action.extension = [action.extension];
					}

					action.extension.forEach(function (ext) {
						extensionSet.add(ext);
					});
				});
			});

			var extensions = [];
			extensionSet.forEach(function (ext) {
				extensions.push(ext);
			});

			return extensions;
		},

		appendItem: function (item)
		{
			if (!(item instanceof BX.UI.Viewer.Item))
			{
				throw new Error("BX.UI.Viewer.Controller.appendItem: 'item' has to be instance of BX.UI.Viewer.Item.");
			}

			item.setController(this);
			this.items.push(item);
		},

		/**
		 * Reloads item in collection items. It means that we replace old item by the one new
		 * which is the copy.
		 * @param {BX.UI.Viewer.Item} item
		 * @param {Object} options
		 */
		reloadItem: function (item, options)
		{
			options = options || {};

			if (!(item instanceof BX.UI.Viewer.Item))
			{
				throw new Error("BX.UI.Viewer.Controller.reloadItem: 'item' has to be instance of BX.UI.Viewer.Item.");
			}

			var index = this.items.indexOf(item);
			if (index === -1)
			{
				throw new Error("BX.UI.Viewer.Controller.reloadItem: there is no 'item' in items to reload.");
			}

			var newItem = null;
			if (item.sourceNode)
			{
				newItem = BX.UI.Viewer.buildItemByNode(item.sourceNode);
			}
			else
			{
				newItem = new item.constructor(item.options);
			}

			newItem.setController(this);
			newItem.applyReloadOptions(options);

			this.items[index] = newItem;
		},

		show: function (index)
		{
			if (typeof index === 'undefined')
			{
				index = 0;
			}

			BX.onCustomEvent('BX.UI.Viewer.Controller:onBeforeShow', [this, index]);

			var item = this.getItemByIndex(index);
			if (!item)
			{
				return;
			}

			this.currentIndex = index;

			this.hideErrorBlock();
			this.hideCurrentItem();
			this.showLoading();

			this.actionPanel.removeItems();
			this.actionPanel.addItems(
				this.convertItemActionsToPanelItems(this.getCurrentItem())
			);

			item.load().then(function (loadedItem) {
				if (this.getCurrentItem() === loadedItem)
				{
					console.log('show item');
					this.processShowItem(loadedItem);
				}
			}.bind(this))
			.catch(function (reason) {
				var loadedItem = reason.item;

				console.log('catch viewer');

				BX.onCustomEvent('BX.UI.Viewer.Controller:onItemError', [this, reason, loadedItem]);

				if (this.getCurrentItem() === loadedItem)
				{
					this.processError(reason, loadedItem);
				}

				BX.onCustomEvent('BX.UI.Viewer.Controller:onAfterProcessItemError', [this, reason, loadedItem]);
			}.bind(this));

			this.updateControls();

			this.lockScroll();
			this.adjustViewerHeight();
		},

		/**
		 * Reloads item and rerun show if item was as current item.
		 * @param {BX.UI.Viewer.Item} item
		 * @param {Object} options
		 */
		reload: function (item, options)
		{
			var isCurrentVisibleItem = this.getCurrentItem() === item;
			this.reloadItem(item, options);

			if (isCurrentVisibleItem)
			{
				console.log('reload');
				this.show(this.currentIndex);
			}
		},

		/**
		 * Reloads and show current item.
		 * @param {?Object} options
		 */
		reloadCurrentItem: function (options)
		{
			this.reload(this.getCurrentItem(), options || {});
		},

		/**
		 * @param {BX.UI.Viewer.Item} item
		 */
		processShowItem: function(item)
		{
			this.hideCurrentItem();
			this.hideLoading();

			var contentWrapper = BX.create('div', {
				props: {
					className: 'ui-viewer-inner-content-wrapper'
				}
			});

			var fragment = document.createDocumentFragment();
			fragment.appendChild(item.render());

			var title = item.getTitle();
			if (title)
			{
				fragment.appendChild(BX.create('div', {
					props: {
						className: 'viewer-inner-caption'
					},
					text: title
				}));
			}

			contentWrapper.appendChild(fragment);
			this.layout.itemContainer.appendChild(contentWrapper);

			item.afterRender();
		},

		/**
		 * @param {Object} reason
		 * @param {BX.UI.Viewer.Item} item
		 */
		processError: function(reason, item)
		{
			reason = reason || {};

			var message = reason.message || null;
			var description = reason.description || null;

			if (BX.type.isArray(reason.errors) && reason.errors.length)
			{
				if (reason.errors[0].code === 1000 && !reason.message)
				{
					message = BX.message('JS_UI_VIEWER_ITEM_TRANSFORMATION_TIMEOUT');
				}
			}

			this.hideCurrentItem();
			this.hideLoading();

			var contentWrapper = BX.create('div', {
				props: {
					className: 'ui-viewer-inner-content-wrapper'
				}
			});

			var title = item.getTitle();
			if (title)
			{
				contentWrapper.appendChild(BX.create('div', {
						props: {
							className: 'viewer-inner-caption'
						},
						text: title
					})
				);
			}

			contentWrapper.appendChild(this.getErrorBlock({
				title: message,
				description: description
			}));
			
			this.layout.itemContainer.appendChild(contentWrapper);
		},

		hideErrorBlock: function()
		{
			if (this.layout.error)
			{
				BX.remove(this.layout.error);
			}
		},

		getErrorBlock: function(options)
		{
			this.hideErrorBlock();

			options = options || {};

			var title = options.title || BX.message('JS_UI_VIEWER_DEFAULT_ERROR_TITLE');
			var description = options.description;

			this.layout.error =  BX.create('div', {
				props: {
					className: 'ui-viewer-error'
				},
				style: {
					maxWidth: description? '440px' : null
				},
				children: [
					BX.create('div', {
						props: {
							className: 'ui-viewer-error-title'
						},
						text: title
					}),
					BX.create('div', {
						props: {
							className: 'ui-viewer-error-text'
						},
						html: description || ''
					})
				]
			});

			return this.layout.error;
		},

		/**
		 * @param {BX.UI.Viewer.Item} item
		 */
		convertItemActionsToPanelItems: function (item)
		{
			return item.getActions().map(function(action) {
				if (BX.type.isFunction(action.action))
				{
					var fn = action.action;
					action.onclick = function(event, panelItem) {
						fn.call(this, item);
					}.bind(this);
				}

				return action;
			}, this);
		},

		/**
		 * @param {BX.UI.Viewer.Item} item
		 */
		refineItemActions: function (item)
		{
			var defaultActions = {
				download: {
					id: 'download',
					type: 'download',
					text: BX.message('JS_UI_VIEWER_ITEM_ACTION_DOWNLOAD'),
					href: item.src,
					buttonIconClass: 'ui-btn-icon-download'
				},
				edit: {
					id: 'edit',
					type: 'edit',
					text: BX.message('JS_UI_VIEWER_ITEM_ACTION_EDIT'),
					buttonIconClass: 'ui-btn-icon-edit'
				},
				share: {
					id: 'share',
					type: 'share',
					text: BX.message('JS_UI_VIEWER_ITEM_ACTION_SHARE'),
					buttonIconClass: 'ui-btn-icon-share'
				},
				info: {
					id: 'info',
					type: 'info',
					text: '',
					buttonIconClass: 'ui-btn-icon-info ui-action-panel-item-last'
				},
				delete: {
					id: 'delete',
					type: 'delete',
					text: BX.message('JS_UI_VIEWER_ITEM_ACTION_DELETE'),
					buttonIconClass: 'ui-btn-icon-remove'
				}
			};

			return item.getNakedActions().map(function(action) {
				if (defaultActions[action.type])
				{
					action = BX.mergeEx(defaultActions[action.type], action)
				}

				if (!action.id)
				{
					action.id = action.type;
				}

				if (!action.action && action.href)
				{
					action.action = function () {
						document.location = action.href;
					};
				}

				if (BX.type.isArray(action.items))
				{
					action.items.forEach(function (item) {
						if (BX.type.isString(item.onclick))
						{
							item.onclick = new Function('event', 'popupItem', item.onclick);
						}
					})
				}

				if (BX.type.isString(action.action))
				{
					var params = action.params || {};
					var actionString = action.action;

					action.action = function(item, additionalParams) {
						try
						{
							var fn = eval(actionString);
							fn.call(this, item, params, additionalParams);
						}
						catch(e)
						{
							console.log(e);
						}
					}.bind(this);
				}

				return action;
			}, this);
		},

		getLoader: function(options)
		{
			if (!this.layout.loader)
			{
				this.layout.loader = BX.create('div', {
					props: {
						className: 'ui-viewer-loader'
					},
					style: {
						zIndex: -1
					},
					children: [
						this.layout.loaderContainer = BX.create('div', {
							props: {
								className: 'ui-viewer-loader-container'
							}
						}),
						this.layout.loaderText = BX.create('div', {
							props: {
								className: 'ui-viewer-loader-text'
							},
							text: ''
						})
					]
				});

				var loader = new BX.Loader({size: 130});
				loader.show(this.layout.loaderContainer);
			}

			return this.layout.loader;
		},

		getPrevButton: function()
		{
			if (!this.layout.prev)
			{
				this.layout.prev = BX.create('div', {
					props: {
						className: 'ui-viewer-prev'
					}
				})
			}

			return this.layout.prev;
		},

		getNextButton: function()
		{
			if (!this.layout.next)
			{
				this.layout.next = BX.create('div', {
					props: {
						className: 'ui-viewer-next'
					}
				});
			}

			return this.layout.next;
		},
		
		getCloseButton: function()
		{
			if (!this.layout.close)
			{
				this.layout.close = BX.create('div', {
					props: {
						className: 'ui-viewer-close'
					},
					html: '<div class="ui-viewer-close-icon"></div>'
				});
			}

			return this.layout.close;
		},

		isOpen: function ()
		{
			return this._isOpen;
		},

		open: function(index)
		{
			this.adjustZindex();

			document.body.appendChild(this.getViewerContainer());
			this.show(index);
			this.showPanel();

			this.bindEvents();

			this._isOpen = true;
		},

		getPanelWrapper: function()
		{
			if (!this.layout.panel)
			{
				this.layout.panel = BX.create('div', {
					props: {
						className: 'ui-viewer-panel'
					}
				});
			}

			return this.layout.panel;
		},

		showPanel: function()
		{
			this.actionPanel.layout.container.style.zIndex = '9999999';
			this.actionPanel.layout.container.style.background = 'none';

			this.actionPanel.draw();
			this.actionPanel.showPanel();
		},

		hideCurrentItem: function()
		{
			BX.cleanNode(this.layout.itemContainer);
		},

		updateControls: function()
		{
			if (!this.allowToUseCycleMode() && this.currentIndex + 1 >= this.items.length)
			{
				BX.addClass(this.getNextButton(), 'ui-viewer-navigation-hide');
			}
			else
			{
				BX.removeClass(this.getNextButton(), 'ui-viewer-navigation-hide');
			}

			if (!this.allowToUseCycleMode() && this.currentIndex === 0)
			{
				BX.addClass(this.getPrevButton(), 'ui-viewer-navigation-hide');
			}
			else
			{
				BX.removeClass(this.getPrevButton(), 'ui-viewer-navigation-hide');
			}
		},

		/**
		 * @return {BX.UI.Viewer.Item}
		 */
		getCurrentItem: function ()
		{
			return this.getItemByIndex(this.currentIndex);
		},

		/**
		 * @param {HTMLElement} node
		 * @return {int}
		 */
		getIndexByNode: function (node)
		{
			var nodeIndex = null;
			this.items.forEach(function (item, index) {
				if (item.sourceNode === node)
				{
					nodeIndex = index;
				}
			});

			return nodeIndex;
		},

		/**
		 *
		 * @param index
		 * @returns BX.UI.Viewer.Item
		 */
		getItemByIndex: function (index)
		{
			index = parseInt(index, 10);

			BX.onCustomEvent('BX.UI.Viewer.Controller:onGetItemByIndex', [this, index]);

			if (index < 0 || (index - 1) > this.items.length)
			{
				return null;
			}

			return this.items[index];
		},

		handleClickOnItemContainer: function (event)
		{
			if (this.getCurrentItem() instanceof BX.UI.Viewer.Image)
			{
				this.showNext();
			}
		},

		allowToUseCycleMode: function ()
		{
			var cycleMode = this.cycleMode;
			var groupBy = this.getCurrentItem().getGroupBy();
			if (this.optionsByGroup[groupBy] && this.optionsByGroup[groupBy].hasOwnProperty('cycleMode'))
			{
				cycleMode = this.optionsByGroup[groupBy].cycleMode;
			}

			return this.items.length > 1 && cycleMode;
		},

		showNext: function ()
		{
			var index = this.currentIndex + 1;
			if (this.allowToUseCycleMode() && index >= this.items.length)
			{
				index = 0;
			}

			this.show(index);
		},

		showPrev: function ()
		{
			var index = this.currentIndex - 1;
			if (this.allowToUseCycleMode() && index === -1)
			{
				index = this.items.length - 1;
			}

			this.show(index);
		},

		close: function ()
		{
			this._isOpen = false;

			BX.onCustomEvent('BX.UI.Viewer.Controller:onClose', [this]);

			BX.addClass(this.layout.container, 'ui-viewer-hide');

			BX.bind(this.layout.container, 'transitionend', function()
			{
				BX.remove(this.layout.container);
				BX.removeClass(this.layout.container, 'ui-viewer-hide');
				BX.unbindAll(this.layout.container);
				this.actionPanel.hidePanel();
				this.unLockScroll();
				this.unbindEvents();
			}.bind(this));

			// this.items = null;
			// this.currentIndex = null;
			// this.layout.container = null;
			// this.layout.close = null;
		},

		showLoading: function (options)
		{
			options = options || {};

			this.layout.inner.appendChild(this.getLoader());
			this.setTextOnLoading(options.text || '');
		},

		setTextOnLoading: function (text)
		{
			this.layout.loaderText.textContent = text;
		},

		hideLoading: function ()
		{
			BX.remove(this.layout.loader);
		},

		lockScroll: function()
		{
			BX.addClass(document.body, 'ui-viewer-lock-body');
		},

		unLockScroll: function()
		{
			BX.removeClass(document.body, 'ui-viewer-lock-body');
		},

		adjustViewerHeight: function()
		{
			if(!this.layout.container)
				return;

			this.layout.container.style.height = document.documentElement.clientHeight + 'px';
		},

		getViewerContainer: function()
		{
			if (!this.layout.container)
			{
				this.layout.container = BX.create('div', {
					props: {
						className: 'ui-viewer'
					},
					style: {
						zIndex: this.zIndex,
						height: window.clientHeight + 'px'
					},
					children: [
						this.layout.inner = BX.create('div', {
							props: {
								className: 'ui-viewer-inner'
							},
							children: [
								this.getItemContainer()
							]
						}),
						this.getCloseButton(),
						this.getPrevButton(),
						this.getNextButton(),
						this.getPanelWrapper()
					]
				});
			}

			return this.layout.container;
		},

		getItemContainer: function()
		{
			if (!this.layout.itemContainer)
			{
				this.layout.itemContainer = BX.create('div', {
					props: {
						className: 'ui-viewer-inner-content'
					}
				});
			}

			return this.layout.itemContainer
		},

		handleTouchStart: function(event)
		{
			var touchObject = event.changedTouches[0];
			this.swipeDirection = null;
			this.startX = touchObject.pageX;
			this.startY = touchObject.pageY;
			this.startTime = (new Date()).getTime();
			event.preventDefault();

		},

		handleTouchEnd: function(event)
		{
			var touchObject = event.changedTouches[0];
			var allowedTime = 300;
			var threshold = 80;
			var restraint = 100;
			var distanceX = touchObject.pageX - this.startX;
			var distanceY = touchObject.pageY - this.startY;
			var elapsedTime = (new Date()).getTime() - this.startTime;

			if (elapsedTime <= allowedTime)
			{
				if (Math.abs(distanceX) >= threshold && Math.abs(distanceY) <= restraint)
				{
					this.swipeDirection = (distanceX < 0) ? 'left' : 'right';
				}
				else if (Math.abs(distanceY) >= threshold && Math.abs(distanceX) <= restraint)
				{
					this.swipeDirection = (distanceY < 0) ? 'up' : 'down';
				}
			}

			switch (this.swipeDirection)
			{
				case 'up':
				case 'left':
					this.showPrev();
					break;
				case 'down':
				case 'right':
					this.showNext();
					break;
			}

			event.preventDefault();
		},

		isOnTop: function ()
		{
			if (!this.isOpen())
			{
				return false;
			}

			if (!BX.getClass('BX.SidePanel.Instance') || !BX.SidePanel.Instance.getTopSlider())
			{
				return true;
			}

			return this.getZindex() > BX.SidePanel.Instance.getTopSlider().getZindex();
		},

		handleKeyPress: function (event)
		{
			if (!this.isOnTop())
			{
				return;
			}

			switch (event.code)
			{
				case 'Space':
				case 'ArrowRight':
				case 'PageDown':
				case 'ArrowDown':
					this.showNext();
					event.preventDefault();
					event.stopPropagation();

					break;
				case 'ArrowLeft':
				case 'PageUp':
				case 'ArrowUp':
					this.showPrev();
					event.preventDefault();
					event.stopPropagation();

					break;
				case 'Escape':
					this.close();
					event.preventDefault();

					break;
			}
		},

		setOptionsByGroup: function (groupBy, options)
		{
			this.optionsByGroup[groupBy] = options;

			return this;
		}
	};

	/**
	 * @param type
	 * @param {HTMLElement} node
	 * @return {BX.UI.Viewer.Item}
	 */
	BX.UI.Viewer.buildItemByTypeAndNode = function (type, node)
	{
		var item = new type();

		if (!(item instanceof BX.UI.Viewer.Item))
		{
			throw new Error("BX.UI.Viewer.buildItemByTypeAndNode: 'item' has to be instance of BX.UI.Viewer.Item.");
		}

		item.setPropertiesByNode(node);
		item.bindSourceNode(node);
		item.setActions(BX.UI.Viewer.Instance.refineItemActions(item));

		return item;
	};

	/**
	 * @param {HTMLElement} node
	 * @returns {BX.UI.Viewer.Item}
	 */
	BX.UI.Viewer.buildItemByNode = function (node)
	{
		if (!BX.type.isDomNode(node))
		{
			throw new Error("BX.UI.Viewer.buildItemByNode: 'node' has to be DomNode.");
		}

		var typeCode = node.dataset.viewerType;
		if (!typeCode && node.tagName.toLowerCase() === 'img')
		{
			typeCode = 'image';
		}

		switch (typeCode)
		{
			case 'image':
				return BX.UI.Viewer.buildItemByTypeAndNode(BX.UI.Viewer.Image, node);
			case 'plainText':
				return BX.UI.Viewer.buildItemByTypeAndNode(BX.UI.Viewer.PlainText, node);
			case 'unknown':
				return BX.UI.Viewer.buildItemByTypeAndNode(BX.UI.Viewer.Unknown, node);
			case 'video':
				return BX.UI.Viewer.buildItemByTypeAndNode(BX.UI.Viewer.Video, node);
			case 'document':
				return BX.UI.Viewer.buildItemByTypeAndNode(BX.UI.Viewer.Document, node);
		}

		if (!node.dataset.viewerTypeClass)
		{
			throw new Error("BX.UI.Viewer.buildItemByNode: there is no data-viewer-type or data-viewer-type-class");
		}

		if (!BX.getClass(node.dataset.viewerTypeClass))
		{
			throw new Error("BX.UI.Viewer.buildItemByNode: could not find class " + node.dataset.viewerTypeClass);
		}

		return BX.UI.Viewer.buildItemByTypeAndNode(BX.getClass(node.dataset.viewerTypeClass), node);
	};

	/**
	 * @param {HTMLElement} container
	 * @param filter
	 * @returns {BX.Promise}
	 */
	BX.UI.Viewer.bind = function (container, filter)
	{
		if (!BX.type.isDomNode(container))
		{
			throw new Error("BX.UI.Viewer.bind: 'container' has to be DomNode.");
		}
		if (!BX.type.isPlainObject(filter) && !BX.type.isFunction(filter))
		{
			filter = function(node) {
				return BX.type.isElementNode(node) && node.dataset.hasOwnProperty('viewer');
			};
		}

		BX.bindDelegate(container, 'click', filter, function(event) {
			var nodes = BX.findChildren(container, filter, true);
			var indexToShow = 0;
			var targetNode = BX.getEventTarget(event);

			var items = nodes.map(function(node, index) {
				if (node === targetNode)
				{
					indexToShow = index;
				}
				return BX.UI.Viewer.buildItemByNode(node);
			});

			BX.UI.Viewer.Instance.setItems(items).then(function () {
				BX.UI.Viewer.Instance.open(indexToShow);
			});

			event.preventDefault();
		});
	};


	var instance = null;
	/**
	 * @memberOf BX.UI.Viewer
	 * @name BX.UI.Viewer#Instance
	 * @type BX.UI.Viewer.Controller
	 * @static
	 * @readonly
	 */
	Object.defineProperty(BX.UI.Viewer, 'Instance', {
		enumerable: false,
		get: function()
		{
			if (window.top !== window && BX.getClass('window.top.BX.UI.Viewer.Instance'))
			{
				return window.top.BX.UI.Viewer.Instance;
			}

			if (instance === null)
			{
				instance = new BX.UI.Viewer.Controller({});
			}

			return instance;
		}
	});

	window.document.addEventListener('click', function(event) {
		if (window.top !== window && !BX.getClass('window.top.BX.UI.Viewer.Instance'))
		{
			top.BX.loadExt('ui.viewer').then(function () {
				top.BX.UI.Viewer.Instance.handleDocumentClick(event);
			});
		}
		else
		{
			top.BX.UI.Viewer.Instance.handleDocumentClick(event);
		}
	}, true);

	//We have to show viewer only in top window not in iframe.
	//So we try to load ui.viewer to the top window if there is no viewer.
	if (window.top !== window && !BX.getClass('window.top.BX.UI.Viewer.Instance'))
	{
		top.BX.loadExt('ui.viewer');
	}
})();