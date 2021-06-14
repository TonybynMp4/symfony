import {Theme} from './Theme';
import {User} from './User';
import {UserHasFavoriteSupport} from './UserHasFavoriteSupport';
import {Language} from './Language';
import {SupportHasMedia} from './SupportHasMedia';
import {SupportHasTag} from './SupportHasTag';

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
	reported: number;
	subTheme?: Theme;
	user?: User;
	usersFavorites?: Array<UserHasFavoriteSupport>;
	language?: Language;
	medias?: Array<SupportHasMedia>;
	tags?: Array<SupportHasTag>;
}