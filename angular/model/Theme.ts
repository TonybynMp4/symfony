import {Theme} from './Theme';

export interface Theme {
	id: number;
	name: string;
	parent?: Theme;
	users?: Array<UserHasTheme>;
	usersFavorites?: Array<UserHasFavoriteTheme>;
	image?: MediaObject;
}