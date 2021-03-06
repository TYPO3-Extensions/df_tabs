/**
 * History
 *
 * @version		1.0
 *
 * @license		MIT License
 * @author		Harald Kirschner <mail [at] digitarald.de>
 * @copyright	2008 Author
 */

var History = Object.append(history, {
	implement: function(obj) {
		return Object.append(this, obj);
	}
});

History.implement(new Events(function() {
}));

History.implement({

	hashState: '',

	start: function() {
		if (this.started) {
			return this;
		}
		this.hashState = this.getHash();
		if (Browser.ie && Browser.version < 8) {
			var iframe = new Element('iframe', {
				'src': "javascript:'<html></html>'",
				'styles': {
					'position': 'absolute',
					'top': '-1000px'
				}
			}).inject(document.body).contentWindow;
			var writeState = function(state) {
				iframe.document.write("<html><body onload=\"top.History.$listener('"
					+ encodeURIComponent(state) + "');\">Moo!</body></html>");
				iframe.document.close();
			};
			Object.append(this, {
				'$listener': function(state) {
					state = decodeURIComponent(state);
					if (this.hashState !== state) {
						this.setHash(state).changeState(state, false);
					}
				}.bind(this),
				'setState': function(state, force) {
					if (this.hashState !== state || force) {
						if (!force) {
							this.setHash(state).changeState(state, true);
						}
						writeState(state);
					}
					return this;
				},
				'trace': function() {
					var state = this.getHash();
					if (state !== this.hashState) {
						writeState(state);
					}
				}
			});
			var check = function() {
				if (iframe.document && iframe.document.body) {
					check = clearInterval(check);
					if (!iframe.document.body.innerHTML) {
						this.setState(this.hashState);
					}
				}
			};
			check.periodical(50, this);
		}
		this.trace.periodical(150, this);
		this.started = true;
		return this;
	},

	changeState: function(state, manual) {
		var stateOld = this.hashState;
		this.hashState = state;
		this.fireEvent('changed', [state, stateOld, manual]);
	},

	trace: function() {
		var state = this.getHash();
		if (state !== this.hashState) {
			this.changeState(state, false);
		}
	},

	getHash: function() {
		var href = location.href, pos = href.indexOf('#') + 1;
		return (pos) ? href.substr(pos) : '';
	},

	setHash: function(state) {
		location.hash = '#' + state;
		return this;
	},

	setState: function(state) {
		if (this.hashState !== state) {
			this.setHash(state).changeState(state, true);
		}
		return this;
	},

	getState: function() {
		return this.hashState;
	}

});
