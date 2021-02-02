import {MediaObject} from './MediaObject';
import {UserHasPersonality} from './UserHasPersonality';
import {UserHasTheme} from './UserHasTheme';
import {UserHasLanguage} from './UserHasLanguage';

export interface User {
	id: number;
	email: string;
	roles: any;
	password: string;
	birthdate: any;
	gender: boolean;
	idSubscription?: string;
	image?: MediaObject;
	personalities?: Array<UserHasPersonality>;
	themes?: Array<UserHasTheme>;
	languages?: Array<UserHasLanguage>;
}