import {Theme} from './Theme';
import {MediaObject} from './MediaObject';
import {User} from './User';
import {UserHasFavoriteSupport} from './UserHasFavoriteSupport';
import {Language} from './Language';

export interface Support {
	id: number;
	title: string;
	subtitle: string;
	type: any;
	videoLink?: string;
	videoLink2?: string;
	description: string;
	description2?: string;
	createdAt: Date;
	level: any;
	subTheme?: Theme;
	image?: MediaObject;
	user?: User;
	usersFavorites?: Array<UserHasFavoriteSupport>;
	language?: Language;
}