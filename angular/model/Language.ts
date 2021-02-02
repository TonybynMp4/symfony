import {UserHasLanguage} from './UserHasLanguage';

export interface Language {
	id: number;
	name: string;
	users?: Array<UserHasLanguage>;
}