import apiFetch from '@wordpress/api-fetch';
import { register, createReduxStore } from '@wordpress/data';

const DEFAULT_STATE = {
	patternData: {},
};

const STORE_NAME = 'kbpg/pattern-data';

const actions = {
	setpatternData( patternData ) {
		return {
			type: 'SET_PATTERN_DATA',
			patternData,
		};
	},
	getpatternData( path ) {
		return {
			type: 'GET_PATTERN_DATA',
			path,
		};
	},
};

const reducer = ( state = DEFAULT_STATE, action ) => {
	switch ( action.type ) {
		case 'SET_PATTERN_DATA': {
			return {
				...state,
				patternData: action.patternData,
			};
		}
		default: {
			return state;
		}
	}
};

const selectors = {
	getPatternData( state ) {
		const { patternData } = state;
		return patternData;
	},
};

const controls = {
	GET_PATTERN_DATA( action ) {
		return apiFetch( { path: action.path } );
	},
};

const resolvers = {
	*getPatternData(args) {
		const patternData = yield actions.getPatternData( '/kbpg/v1/pattern/' + args.id );
		return actions.setPatternData( patternData );
	},
};

const storeConfig = {
	reducer,
	controls,
	selectors,
	resolvers,
	actions,
};

export const patternDataStore = createReduxStore( STORE_NAME, storeConfig );

register( patternDataStore );
