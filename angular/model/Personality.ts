import {UserHasPersonality} from './UserHasPersonality';

export interface Personality {
	id: number;
	name: string;
	users?: Array<UserHasPersonality>;
}