import {Theme} from './Theme';
import {Language} from './Language';
import {MediaObject} from './MediaObject';
import {UserHasEvent} from './UserHasEvent';
import {User} from './User';
import {Message} from './Message';

export interface Event {
	id: number;
	title: string;
	timeToStart: Date;
	duration: any;
	place: string;
	supportType: any;
	type: boolean;
	level: any;
	description?: string;
	nbMaxParticipants?: number;
	createdAt: Date;
	theme?: Theme;
	language?: Language;
	image?: MediaObject;
	users?: Array<UserHasEvent>;
	owner?: User;
	messages?: Array<Message>;
}