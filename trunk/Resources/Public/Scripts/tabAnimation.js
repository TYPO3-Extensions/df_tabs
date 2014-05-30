/**
 * Smooth Image Transition effect
 *
 * @author Stefan Galinski <stefan.galinski@gmail.com>
 */
var dfTabsSmoothImageTransition = {
	/**
	 * Preparation for the animation effects
	 *
	 * @param {TabBar} tabBar
	 * @return {void}
	 */
	beforeInitialize: function(tabBar) {
		if (jQuery) {
			$.each(tabBar.elementMap, function(index, element) {
				if (!element.contentItem.hasClass(tabBar.options.classPrefix + 'tabContentSelected')) {
					element.contentItem.css('display', 'none');
				}
			});
		} else {
			tabBar.elementMap.each(function(element) {
				element.contentItem.set('tween', {
					duration: tabBar.options.animationSpeed
				});

				if (!element.contentItem.hasClass(tabBar.options.classPrefix + 'tabContentSelected')) {
					element.contentItem.fade('hide');
				}
			});
		}
	},

	/**
	 * Animates the transition between two tabs
	 *
	 * @param {int} nextTabIndex
	 * @return {void}
	 */
	tabChange: function(nextTabIndex) {
		if (this.previousTab < 0) {
			return;
		}

		var selectedClass = '';
		if (jQuery) {
			this.elementMap[this.previousTab].contentItem.fadeOut(this.options.animationSpeed);
			this.elementMap[nextTabIndex].contentItem.fadeIn(this.options.animationSpeed);

			selectedClass = this.options.classPrefix + 'tabMenuEntrySelected';
			$.each(this.elementMap, function(index, element) {
				element.menuItem.removeClass(selectedClass);
			});
		} else {
			this.elementMap[this.previousTab].contentItem.fade('out');
			this.elementMap[nextTabIndex].contentItem.fade('in');

			selectedClass = this.options.classPrefix + 'tabMenuEntrySelected';
			this.elementMap.each(function(element) {
				element.menuItem.removeClass(selectedClass);
			});
		}

		this.elementMap[nextTabIndex].menuItem.addClass(selectedClass);
		this.previousTab = nextTabIndex;
	}
};