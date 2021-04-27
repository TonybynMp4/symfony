import {User} from './User';
import {Support} from './Support';

export interface UserHasFavoriteSupport {
	id: number;
	user?: User;
	support?: Support;
}