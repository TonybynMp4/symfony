import {User} from './User';
import {Personality} from './Personality';

export interface UserHasPersonality {
	id: number;
	user?: User;
	personality?: Personality;
}