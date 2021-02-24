import {Theme} from './Theme';
import {MediaObject} from './MediaObject';
import {User} from './User';
import {UserHasFavoriteSupport} from './UserHasFavoriteSupport';

export interface Support {
	id: number;
	title: string;
	subtitle: string;
	type: any;
	description: string;
	legend: string;
	createdAt: Date;
	level: any;
	subTheme?: Theme;
	image?: MediaObject;
	user?: User;
	usersFavorites?: Array<UserHasFavoriteSupport>;
}