import {User} from './User';
import {Language} from './Language';

export interface UserHasLanguage {
	id: number;
	level: any;
	user?: User;
	language?: Language;
}