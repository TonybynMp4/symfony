import {User} from './User';
import {Event} from './Event';

export interface UserHasEvent {
	id: number;
	user?: User;
	event?: Event;
}