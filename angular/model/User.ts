import {MediaObject} from './MediaObject';
import {UserHasPersonality} from './UserHasPersonality';
import {UserHasTheme} from './UserHasTheme';
import {UserHasEvent} from './UserHasEvent';
import {UserHasFavoriteTheme} from './UserHasFavoriteTheme';
import {UserHasFavoriteSupport} from './UserHasFavoriteSupport';
import {Support} from './Support';
import {Message} from './Message';
import {UserHasLanguage} from './UserHasLanguage';
import {Language} from './Language';

export interface User {
	id: number;
	email: string;
	name: string;
	roles: any;
	password: string;
	newPassword?: string;
	birthdate: any;
	gender: boolean;
	idSubscription?: string;
	createdAt: Date;
	image?: MediaObject;
	personalities?: Array<UserHasPersonality>;
	themes?: Array<UserHasTheme>;
	events?: Array<UserHasEvent>;
	favoriteThemes?: Array<UserHasFavoriteTheme>;
	favoriteSupports?: Array<UserHasFavoriteSupport>;
	supports?: Array<Support>;
	messages?: Array<Message>;
	languages?: Array<UserHasLanguage>;
	languageDefault?: Language;
}