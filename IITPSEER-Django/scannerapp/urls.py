"""scannerapp URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/2.1/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.urls import path
from django.conf import settings
from django.conf.urls.static import static

urlpatterns = [
    path('admin/', admin.site.urls),
]
from django.conf.urls import url, include
from rest_framework import routers
from people import views as PeopleViews
from entryexit import views as EntryExitViews

router = routers.DefaultRouter()
router.register(r'users', PeopleViews.UserViewSet)
router.register(r'groups', PeopleViews.GroupViewSet)
router.register(r'building', EntryExitViews.BuildingViewSet)

# Wire up our API using automatic URL routing.
# Additionally, we include login URLs for the browsable API.
urlpatterns = [
    url(r'^', include(router.urls)),
    url(r'^admin/', admin.site.urls),
    url(r'^api-auth/', include('rest_framework.urls', namespace='rest_framework')),
    path('api/login', PeopleViews.login),

    url(r'^people/$', PeopleViews.PeopleListAPIView.as_view(), name = 'peoplelist'),
    url(r'^people/create/$', PeopleViews.PeopleCreateAPIView.as_view(), name = 'people_create'),
    url(r'^people/(?P<pk>\w+)/$', PeopleViews.PeopleDetailAPIView.as_view(), name = 'people_detail_patch'),
    url(r'^people/(?P<pk>\w+)/delete/$', PeopleViews.PeopleDeleteAPIView.as_view(), name = 'people_delete'),
    
    
    url(r'^entryexit/$', EntryExitViews.EntryExitListAPIView.as_view(), name = 'entryexitlist'),
    url(r'^entry/$', EntryExitViews.EntryAPIView.as_view(), name = 'entry_create_update'),
    url(r'^exit/$', EntryExitViews.ExitAPIView.as_view(), name = 'exit_create_update'),


] + static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)
