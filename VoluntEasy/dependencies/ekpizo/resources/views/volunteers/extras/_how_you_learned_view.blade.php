<p><strong>{{ trans('entities/volunteers.howTheyLearned') }}:</strong> {{ $volunteer->howYouLearned==null || $volunteer->howYouLearned=='' ? '-' : $volunteer->howYouLearned->description}}</p>
<p><strong>{{ trans('entities/volunteers.howTheyLearned2') }}:</strong> {{ $volunteer->howYouLearned2==null || $volunteer->howYouLearned2=='' ? '-' : $volunteer->howYouLearned2->description}}</p>
