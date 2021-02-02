import {UserHasTheme} from './UserHasTheme';
import {MediaObject} from './MediaObject';

export interface Theme {
	id: number;
	name: string;
	users?: Array<UserHasTheme>;
	image?: MediaObject;
}