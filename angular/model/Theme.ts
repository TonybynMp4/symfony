import {Theme} from './Theme';

export interface Theme {
	id: number;
	name: string;
	parent?: Theme;
	usersFavorites?: Array<UserHasFavoriteTheme>;
	image?: MediaObject;
}