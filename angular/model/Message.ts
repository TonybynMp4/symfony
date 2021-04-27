import {User} from './User';
import {User} from './User';
import {Event} from './Event';

export interface Message {
	id: number;
	content: string;
	lastUpdated: Date;
	read: boolean;
	owner?: User;
	userDelivery?: User;
	event?: Event;
}