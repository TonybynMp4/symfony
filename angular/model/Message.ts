import {User} from './User';
import {User} from './User';
import {Event} from './Event';

export interface Message {
	id: number;
	content: string;
	lastUpdated: Date;
	view: boolean;
	conversation?: string;
	owner?: User;
	userDelivery?: User;
	event?: Event;
}