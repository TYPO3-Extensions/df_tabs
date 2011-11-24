/**
 * A tab-bar widget with very basic functionality
 *
 * @author Stefan Galinski <stefan.galinski@gmail.com>
 */
var TabBar = new Class({
	Implements: [Options, Events],

	/**
	 * Available options
	 *
	 * startIndex: starting tab index (beginning at 0)
	 * enableAjax: ajax mode (post-loading of contents)
	 * ajaxPageId: TYPO3 page id (needed in AJAX case)
	 * ajaxRecords: Record ids (e.g. pages_12,tt_content4; needed in AJAX case)
	 * ajaxPluginMode: Plugin Mode (typoscript, pages, tt_content or combined)
	 * enableAutoPlay: usage of an auto play mechanism to switch between tabs
	 * autoPlayInterval: the time gap between the switch between two slides
	 * enableMouseOver: usage of mouse over in addition the normal click event for changing a tab
	 * classPrefix: prefix for all assigned classes
	 * hashName: prefix for the location hash listener
	 * pollingInterval: location hash polling interval
	 * animateCallback: animation callback function
	 *
	 * Events:
	 * onBeforeInitialize
	 * onAfterInitialize
	 * onTabChange
	 *
	 * @cfg {Object}
	 */
	options: {
		startIndex: 0,
		enableAjax: false,
		ajaxPageId: 0,
		ajaxRecords: '',
		ajaxPluginMode: '',
		enableAutoPlay: false,
		autoPlayInterval: 7000,
		enableMouseOver: false,
		classPrefix: 'tx-dftabs-',
		hashName: 'tab',
		pollingInterval: 1000,
		animationCallback: null,

		onBeforeInitialize: null,
		onAfterInitialize: null,
		onTabChange: null
	},

	/**
	 * Tab Entry Array with Fields of Type "Object"
	 *
	 * Structure:
	 * menuItem: related menu element
	 * contentItem: related content element
	 *
	 * @type {Array}
	 */
	elementMap: [],

	/**
	 * The Active Tab
	 *
	 * @type {int}
	 */
	previousTab: -1,

	/**
	 * The AutoPlay Instance
	 *
	 * @type {Object}
	 */
	autoPlay: null,

	/**
	 * Timed Display Method
	 *
	 * @type {Function}
	 */
	timedDisplayFunction: null,

	/**
	 * Initializes the tab widget
	 *
	 * @param {string} menuEntries
	 * @param {string} contentEntries
	 * @param {object} options
	 * @return {void}
	 */
	initialize: function(menuEntries, contentEntries, options) {
		this.setOptions(options);

		for (var i = 0; i < menuEntries.length; ++i) {
			this.elementMap[i] = {};
			this.elementMap[i].menuItem = menuEntries[i];
			this.elementMap[i].contentItem = contentEntries[i];
		}

		if (this.options.enableAjax) {
			this.loadAjaxContents();
		} else {
			this.finalizeInitialisation();
		}
	},

	/**
	 * Finalizes the initialisation for e.g. after the ajax loading of the contents
	 *
	 * @return {void}
	 */
	finalizeInitialisation: function() {
		this.fireEvent('onBeforeInitialize', this);

		this.previousTab = this.options.startIndex;
		this.parseContentLinks().addEvents().startAutoPlay().initHistory();

		this.fireEvent('onAfterInitialize', this);
	},

	/**
	 * Loads the remaining ajax contents and calls the
	 * finalizeInitialisation() method afterwards.
	 *
	 * @return {void}
	 */
	loadAjaxContents: function() {
		(new Request({
			method: 'get',
			url: 'index.php?eID=dftabs',
			onComplete: function(response) {
				var elements = new Element('div', {	html: response }).getChildren();
				Object.each(elements, function(response, index) {
					var element = $(this.options.classPrefix + 'tabContent' + (parseInt(index) + 1));
					if (element) {
						element.set('html', '');
						element.grab(response);
					}
				}.bind(this));

				this.finalizeInitialisation();
			}.bind(this)
		})).send(
			'df_tabs[id]=' + this.options.ajaxPageId +
			'&df_tabs[records]=' + this.options.ajaxRecords +
			'&df_tabs[mode]=' + this.options.ajaxPluginMode
		);
	},

	/**
	 * Parses all links and adds a smooth scrolling to the tab if the link
	 * references to an internal tab on the very same page
	 *
	 * @return {TabBar}
	 */
	parseContentLinks: function() {
		this.elementMap.each(function(element) {
			var links = element.contentItem.getElements('a');
			links.each(function(link) {
				var parts = link.href.split('#');
				if (parts[0] === location.href.split('#')[0]) {
					var index = parts[1].substr(this.options.hashName.length);
					link.addEvent('click', this.scrollToTab.pass(index, this));
				}
			}.bind(this));
		}.bind(this));

		return this;
	},

	/**
	 * Scrolls to the menu item of the given tab index
	 *
	 * @param {int} tabIndex
	 * @return {void}
	 */
	scrollToTab: function(tabIndex) {
		(new Fx.Scroll(window, {
			offset: {
				x: 0,
				y: this.elementMap[tabIndex].menuItem.getCoordinates().top
			}
		})).toTop();
	},

	/**
	 * Adds the requested events to the tab menu elements
	 *
	 * @return {TabBar}
	 */
	addEvents: function() {
		this.elementMap.each(function(element, index) {
			if (this.options.enableMouseOver) {
				element.menuItem.addEvent('mouseenter', this.timedDisplay.pass([index], this));
				element.contentItem.addEvent('mouseenter', this.clearTimedDisplay.bind(this));
			} else {
				element.menuItem.addEvent('click', this.display.pass([index], this));
			}

			if (this.options.enableAutoPlay) {
				if (this.options.enableMouseOver) {
					element.menuItem.addEvents({
						'mouseenter': this.stopAutoPlay.bind(this),
						'mouseleave': this.startAutoPlay.bind(this),
						'click': this.startAutoPlay.bind(this)
					});
				} else {
					element.menuItem.addEvent('click', this.stopAutoPlay.bind(this));
				}
			}
		}.bind(this));

		return this;
	},

	/**
	 * Initializes the History manager that manages an History to rebuild the back button
	 * mechanism.
	 *
	 * @return {void}
	 */
	initHistory: function() {
		// configure the History routing mechanism
		var history = new History.Route({
			defaults: [],
			flags: 'i',
			pattern: '(?:^|' + History.options.separator + ')' + this.options.hashName + '(\\d+)',

			// called if a new History entry is created to generate the History key
			generate: function(values) {
				var index = parseInt(values[0], 10);
				return this.options.hashName + (index ? index : '');
			}.bind(this),

			// called if match of the History key occurred while the hash of the url changed
			onMatch: function(values) {
				var index = parseInt(values[0], 10);

				if (isNaN(index) && this.previousTab !== this.options.startIndex) {
					this.display(this.options.startIndex);
					this.fireEvent('historyBackToStartPage', this);

				} else if (index >= 0 && index < this.elementMap.length) {
					this.display(index);
					this.fireEvent('menuEntryClicked', [this, index]);
				}
			}.bind(this)
		});

		// initial check if a matching hash was appended to the URL and apply the new state
		History.trace();

		// add listening mechanism to change the contents if the anchor was manually changed
		// or the back button was pressed
		History.start();

		// fire the onHistoryInitialized event
		this.fireEvent('historyInitialized', this);
	},

	/**
	 * Adds a small delay before displaying a tab (useful for mouseover)
	 *
	 * Note: The delay method is saved in the class property "timedDisplayFunction".
	 *
	 * @param {int} nextTabIndex
	 * @return {TabBar}
	 */
	timedDisplay: function(nextTabIndex) {
		this.clearTimedDisplay();
		this.timedDisplayFunction = this.display.delay(250, this, [nextTabIndex]);

		return this;
	},

	/**
	 * Clears the timed display function
	 *
	 * @return {TabBar}
	 */
	clearTimedDisplay: function() {
		clearTimeout(this.timedDisplayFunction);

		return this;
	},

	/**
	 * Displays the given tab index
	 *
	 * @param {int} nextTabIndex
	 * @param {Boolean} triggeredByAutoPlay
	 * @return {TabBar}
	 */
	display: function(nextTabIndex, triggeredByAutoPlay) {
		if (triggeredByAutoPlay !== true) {
			triggeredByAutoPlay = false;
		}

		nextTabIndex = parseInt(nextTabIndex);
		if (isNaN(nextTabIndex) || this.previousTab === nextTabIndex ||
			nextTabIndex < 0 || nextTabIndex >= this.elementMap.length
		) {
			return this;
		}

		if (this.options.animationCallback) {
			this.options.animationCallback.pass([nextTabIndex, triggeredByAutoPlay], this)();
		} else {
			this.animate(nextTabIndex);
		}

		this.fireEvent('onTabChange', [this, this.previousTab, nextTabIndex]);

		return this;
	},

	/**
	 * Default "animation" of the transition between two tabs. In real it's just
	 * a toggling of the selected classes for the content and menu items. Define
	 * your own animation function to get a nice effect.
	 *
	 * @param {int} nextTabIndex
	 * @return {TabBar}
	 */
	animate: function(nextTabIndex) {
		this.toggleContentItemSelectionClasses(nextTabIndex);
		this.toggleMenuEntrySelectionClasses(nextTabIndex);
		this.previousTab = nextTabIndex;

		return this;
	},

	/**
	 * Toggles the "tabContentSelected" class on the last and current content elements
	 *
	 * @param {int} nextTabIndex
	 * @return {TabBar}
	 */
	toggleContentItemSelectionClasses: function(nextTabIndex) {
		var selectedClass = this.options.classPrefix + 'tabContentSelected';
		this.elementMap[this.previousTab].contentItem.removeClass(selectedClass);
		this.elementMap[nextTabIndex].contentItem.addClass(selectedClass);

		return this;
	},

	/**
	 * Toggles the "tabMenuEntrySelected" class on the last and current menu entries
	 *
	 * @param {int} nextTabIndex
	 * @return {TabBar}
	 */
	toggleMenuEntrySelectionClasses: function(nextTabIndex) {
		var selectedClass = this.options.classPrefix + 'tabMenuEntrySelected';
		this.elementMap[nextTabIndex].menuItem.addClass(selectedClass);

		if (Browser.ie && Browser.version < 10) {
			this.elementMap[this.previousTab].menuItem.removeClass(selectedClass).
				setStyle('visibility', 'hidden').setStyle('visibility', 'visible');
		} else {
			this.elementMap[this.previousTab].menuItem.removeClass(selectedClass);
		}

		return this;
	},

	/**
	 * Implements the auto-play mechanism
	 *
	 * @return {void}
	 */
	autoPlayMechanism: function() {
		if (this.previousTab < this.elementMap.length - 1) {
			this.display(this.previousTab + 1, true);
		} else {
			this.display(0, true);
		}
	},

	/**
	 * Starts the auto-play mechanism
	 *
	 * @return {TabBar}
	 */
	startAutoPlay: function() {
		if (this.options.enableAutoPlay && !this.autoPlay) {
			this.autoPlay = this.autoPlayMechanism.periodical(this.options.autoPlayInterval, this);
		}

		return this;
	},

	/**
	 * Stops the auto-play mechanism
	 *
	 * @return {TabBar}
	 */
	stopAutoPlay: function() {
		clearInterval(this.autoPlay);
		this.autoPlay = null;

		return this;
	}
});