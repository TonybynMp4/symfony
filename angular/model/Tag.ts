import {SupportHasTag} from './SupportHasTag';

export interface Tag {
	id: number;
	name: string;
	supports?: Array<SupportHasTag>;
}