import {Theme} from './Theme';
import {SupportHasMediaObject} from './SupportHasMediaObject';
import {User} from './User';
import {UserHasFavoriteSupport} from './UserHasFavoriteSupport';
import {Language} from './Language';

export interface Support {
	id: number;
	title: string;
	subtitle: string;
	type: any;
	type2?: any;
	videoLink?: string;
	videoLink2?: string;
	description: string;
	description2?: string;
	createdAt: Date;
	lastUpdated: Date;
	level: any;
	subTheme?: Theme;
	medias?: Array<SupportHasMediaObject>;
	user?: User;
	usersFavorites?: Array<UserHasFavoriteSupport>;
	language?: Language;
}