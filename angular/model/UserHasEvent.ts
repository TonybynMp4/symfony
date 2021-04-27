import {User} from './User';
import {Event} from './Event';

export interface UserHasEvent {
	id: number;
	accepted: boolean;
	user?: User;
	event?: Event;
}